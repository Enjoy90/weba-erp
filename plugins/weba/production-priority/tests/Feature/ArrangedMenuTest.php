<?php

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\CriterionResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource;
use Weba\ProductionPriority\Filament\Pages\DailyProductionReport;
use Weba\ProductionPriority\Filament\Pages\ProductionDashboard;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Weba\ProductionPriority\Navigation\WorkNavigationManager;
use Weba\ProductionPriority\Services\ProductionOverview;
use Webkul\Inventory\Filament\Clusters\Operations\Resources\QuantityResource;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\ManufacturingOrderResource;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\WorkOrderResource;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Security\PermissionRegistrar;
use Webkul\Support\Enums\NavigationGroup as NavigationGroupEnum;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/support/tests/Helpers/SecurityHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';

beforeEach(function () {
    TestBootstrapHelper::ensurePluginInstalled('inventories');
    TestBootstrapHelper::ensurePluginInstalled('manufacturing');
    TestBootstrapHelper::ensurePluginInstalled('production-priority');

    (new CriterionSeeder)->run();

    foreach (['inventories', 'manufacturing', 'production-priority'] as $plugin) {
        DB::table('plugins')->updateOrInsert(
            ['name' => $plugin],
            ['is_installed' => true, 'is_active' => true, 'updated_at' => now()],
        );
    }

    Package::$plugins = Plugin::all()->keyBy('name');

    URL::resolveMissingNamedRoutesUsing(fn () => '#');

    Filament::setCurrentPanel(Filament::getPanel('admin'));
    App::setLocale('en');
});

/**
 * @return list<string>
 */
function menuGroupLabels(): array
{
    return collect(Filament::getNavigation())->map(fn (NavigationGroup $group): string => (string) $group->getLabel())->all();
}

/**
 * @return array<string, list<string>>
 */
function menuUrlsByGroup(): array
{
    return collect(Filament::getNavigation())
        ->mapWithKeys(fn (NavigationGroup $group): array => [
            (string) $group->getLabel() => collect($group->getItems())->map(fn (NavigationItem $item): string => (string) $item->getUrl())->all(),
        ])
        ->all();
}

/**
 * @return list<string>
 */
function menuItemLabels(): array
{
    return collect(Filament::getNavigation())
        ->flatMap(fn (NavigationGroup $group): array => collect($group->getItems())->map(fn (NavigationItem $item): string => $item->getLabel())->all())
        ->all();
}

it('replaces the menu builder of Filament with the one that rearranges', function () {
    expect(app(NavigationManager::class))->toBeInstanceOf(WorkNavigationManager::class);
});

it('puts dashboard, manufacturing and inventory first and keeps the other groups after them', function () {
    ManufacturingHelper::actingAsAdmin();

    $labels = menuGroupLabels();

    expect(array_slice($labels, 0, 3))->toBe([
        NavigationGroupEnum::Dashboard->getLabel(),
        NavigationGroupEnum::Manufacturing->getLabel(),
        NavigationGroupEnum::Inventory->getLabel(),
    ])->and(array_slice($labels, 3))->not->toContain(NavigationGroupEnum::Manufacturing->getLabel());
});

it('lists the chosen manufacturing items first and the original items after them', function () {
    ManufacturingHelper::actingAsAdmin();

    $urls = menuUrlsByGroup()[NavigationGroupEnum::Manufacturing->getLabel()];

    expect(array_slice($urls, 0, 6))->toBe([
        ManufacturingOrderResource::getUrl('index'),
        WorkOrderResource::getUrl('index'),
        EvaluationResource::getUrl('index'),
        OrderMonitoringResource::getUrl('index'),
        DailyProductionReport::getUrl(),
        CriterionResource::getUrl('index'),
    ])->and(count($urls))->toBeGreaterThan(6);
});

it('puts material stock first in the inventory group', function () {
    ManufacturingHelper::actingAsAdmin();

    expect(menuUrlsByGroup()[NavigationGroupEnum::Inventory->getLabel()][0])->toBe(QuantityResource::getUrl('index'));
});

it('keeps the dashboard pages in the dashboard group', function () {
    ManufacturingHelper::actingAsAdmin();

    expect(menuUrlsByGroup()[NavigationGroupEnum::Dashboard->getLabel()])->toBe([
        WorkPanel::getUrl(),
        ProductionDashboard::getUrl(),
    ]);
});

it('does not lose a single item of the menu Filament builds, and shows none twice', function () {
    ManufacturingHelper::actingAsAdmin();

    $arranged = collect(menuUrlsByGroup())->flatten()->all();

    $original = collect((new NavigationManager)->get())
        ->flatMap(fn (NavigationGroup $group): array => collect($group->getItems())->map(fn (NavigationItem $item): string => (string) $item->getUrl())->all())
        ->unique()
        ->values()
        ->all();

    expect(array_diff($original, $arranged))->toBe([])
        ->and($arranged)->toBe(array_values(array_unique($arranged)))
        ->and(count($arranged))->toBeGreaterThan(count($original));
});

it('has no empty group', function () {
    ManufacturingHelper::actingAsAdmin();

    foreach (menuUrlsByGroup() as $label => $urls) {
        expect($urls)->not->toBeEmpty("group [{$label}] is empty");
    }
});

it('skips the purchasing shortcut when the purchase module is not installed', function () {
    ManufacturingHelper::actingAsAdmin();

    expect(menuItemLabels())->not->toContain('Purchasing');
});

it('shows a user none of the chosen shortcuts without the permissions behind them', function () {
    $user = SecurityHelper::authenticateWithPermissions([]);
    $user->forceFill(['is_active' => true])->saveQuietly();
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    $urls = collect(menuUrlsByGroup())->flatten()->all();

    expect($urls)->not->toContain(ManufacturingOrderResource::getUrl('index'))
        ->and($urls)->not->toContain(QuantityResource::getUrl('index'))
        ->and($urls)->not->toContain(WorkPanel::getUrl())
        ->and(menuGroupLabels())->not->toContain(NavigationGroupEnum::Manufacturing->getLabel());
});

it('names the chosen items in both languages', function () {
    ManufacturingHelper::actingAsAdmin();

    $english = menuItemLabels();

    App::setLocale('id');
    $indonesian = menuItemLabels();

    expect($english)->toContain('Production orders', 'Work orders', 'SAW priorities', 'Order monitoring', 'Criteria and weights', 'Material stock')
        ->and($indonesian)->toContain('Order produksi', 'Work order', 'Prioritas SAW', 'Monitoring order', 'Kriteria dan bobot', 'Stok bahan');
});

it('marks a chosen item as active on its own page', function () {
    ManufacturingHelper::actingAsAdmin();

    $html = $this->get(ManufacturingOrderResource::getUrl('index'))->assertOk()->getContent();

    expect($html)->toMatch('/<li[^>]*class="[^"]*fi-sidebar-item[^"]*fi-active[^"]*"[^>]*>\s*<a[^>]*href="'.preg_quote(ManufacturingOrderResource::getUrl('index'), '/').'"/s');
});

it('lights up only the shortcut, not also the original item of the same cluster', function () {
    ManufacturingHelper::actingAsAdmin();

    $html = $this->get(ManufacturingOrderResource::getUrl('index'))->assertOk()->getContent();

    preg_match_all('/<li[^>]*class="[^"]*fi-sidebar-item[^"]*fi-active[^"]*"[^>]*>\s*<a[^>]*href="([^"]+)"/s', $html, $matches);

    expect(array_values(array_unique($matches[1])))->toBe([ManufacturingOrderResource::getUrl('index')]);
});

it('draws a line between the shortcuts and the original items of a group, and nowhere else', function () {
    ManufacturingHelper::actingAsAdmin();

    $html = $this->get(WorkPanel::getUrl())->assertOk()->getContent();

    $groupsWithBoth = collect(Filament::getNavigation())
        ->filter(fn (NavigationGroup $group): bool => collect($group->getItems())
            ->contains(fn (NavigationItem $item): bool => $item->getKey() === WorkNavigationManager::ORIGINAL_ITEMS_START))
        ->map(fn (NavigationGroup $group): string => (string) $group->getLabel())
        ->values()
        ->all();

    expect($groupsWithBoth)->toBe([
        NavigationGroupEnum::Manufacturing->getLabel(),
        NavigationGroupEnum::Inventory->getLabel(),
    ])->and(substr_count($html, 'class="wp-sidebar-divider"'))->toBe(2);
});

it('gives every item of the menu an icon', function () {
    ManufacturingHelper::actingAsAdmin();

    $withoutIcon = collect(Filament::getNavigation())
        ->flatMap(fn (NavigationGroup $group): array => collect($group->getItems())->all())
        ->filter(fn (NavigationItem $item): bool => $item->getIcon() === null)
        ->map(fn (NavigationItem $item): string => $item->getLabel())
        ->values()
        ->all();

    expect($withoutIcon)->toBe([]);
});

it('returns the menu untouched when it cannot be arranged safely', function () {
    $manager = new class extends WorkNavigationManager
    {
        /**
         * @param  array<NavigationGroup>  $groups
         */
        public function check(array $groups): bool
        {
            return $this->canBeArranged($groups);
        }
    };

    $item = fn (string $url): NavigationItem => NavigationItem::make('x')->url($url);

    expect($manager->check([NavigationGroup::make('A')->items([$item('/a')]), NavigationGroup::make('B')->items([$item('/b')])]))->toBeTrue()
        ->and($manager->check([NavigationGroup::make('A')->items([$item('/a')]), NavigationGroup::make('A')->items([$item('/b')])]))->toBeFalse()
        ->and($manager->check([NavigationGroup::make('A')->items([$item('/a')]), NavigationGroup::make('B')->items([$item('/a')])]))->toBeFalse();
});

function menuBadgeOfProductionOrders(): ?string
{
    $item = collect(Filament::getNavigation())
        ->flatMap(fn (NavigationGroup $group): array => collect($group->getItems())->all())
        ->first(fn (NavigationItem $item): bool => $item->getUrl() === ManufacturingOrderResource::getUrl('index'));

    return $item?->getBadge();
}

function menuLateOrder(object $test, int $deadlineInDays, string $state = 'confirmed'): Order
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);
    $order = ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 5));

    DB::table('manufacturing_orders')->where('id', $order->id)->update([
        'deadline_at' => now()->addDays($deadlineInDays),
        'state'       => $state,
    ]);

    return $order->refresh();
}

describe('late order badge', function () {
    beforeEach(function () {
        $this->warehouse = InventoryHelper::warehouse();
        $this->finished = ManufacturingHelper::product();
        $this->component = ManufacturingHelper::product();
    });

    it('shows nothing while no order is late', function () {
        ManufacturingHelper::actingAsAdmin();

        menuLateOrder($this, 5);

        expect(menuBadgeOfProductionOrders())->toBeNull();
    });

    it('shows how many open orders are late, the same number as the daily work panel', function () {
        ManufacturingHelper::actingAsAdmin();

        menuLateOrder($this, -2);
        menuLateOrder($this, -1, 'progress');
        menuLateOrder($this, -3, 'done');
        menuLateOrder($this, 4);

        app()->forgetScopedInstances();
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        expect(menuBadgeOfProductionOrders())->toBe('2')
            ->and(app(ProductionOverview::class)->stats()['late'])->toBe(2);
    });

    it('is red', function () {
        ManufacturingHelper::actingAsAdmin();

        menuLateOrder($this, -2);

        $item = collect(Filament::getNavigation())
            ->flatMap(fn (NavigationGroup $group): array => collect($group->getItems())->all())
            ->first(fn (NavigationItem $item): bool => $item->getUrl() === ManufacturingOrderResource::getUrl('index'));

        expect($item->getBadgeColor())->toBe('danger');
    });

    it('costs one query however often and however many orders', function () {
        ManufacturingHelper::actingAsAdmin();

        collect(range(1, 4))->each(fn (int $days) => menuLateOrder($this, -$days));

        $navigation = Filament::getNavigation();

        $item = collect($navigation)
            ->flatMap(fn (NavigationGroup $group): array => collect($group->getItems())->all())
            ->first(fn (NavigationItem $item): bool => $item->getUrl() === ManufacturingOrderResource::getUrl('index'));

        DB::flushQueryLog();
        DB::enableQueryLog();
        $item->getBadge();
        $item->getBadge();
        $item->getBadge();
        $queries = count(DB::getQueryLog());
        DB::disableQueryLog();

        expect($queries)->toBe(1);
    });
});
