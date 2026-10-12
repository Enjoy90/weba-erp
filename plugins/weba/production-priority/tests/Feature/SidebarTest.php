<?php

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Filament\Pages\ProductionDashboard;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Webkul\Partner\Models\Partner;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Security\PermissionRegistrar;
use Webkul\Support\Filament\Pages\Help;

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
});

/**
 * @return list<array{group: string, urls: list<string>}>
 */
function sidebarEntries(): array
{
    return collect(Filament::getNavigation())
        ->map(fn (NavigationGroup $group): array => [
            'group' => (string) $group->getLabel(),
            'urls'  => collect($group->getItems())->map(fn ($item): string => (string) $item->getUrl())->all(),
        ])
        ->all();
}

describe('sidebar styles', function () {
    it('registers the stylesheet of the sidebar', function () {
        expect(FilamentAsset::getStyleHref('sidebar', 'production-priority'))->toBeString()->toContain('sidebar');
    });

    it('stops the page from bouncing past its edge when the touchpad scroll reaches an end', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/sidebar.css');

        expect($css)->toMatch('/html,\s*body\s*\{\s*overscroll-behavior:\s*none;/')
            ->and($css)->toMatch('/\.fi-sidebar-nav\s*\{\s*overscroll-behavior:\s*contain;/');
    });

    it('makes every scrollbar of the panel thin, with a thumb of both themes', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/sidebar.css');

        expect($css)->toMatch('/\*\s*\{\s*scrollbar-width:\s*thin;/')
            ->and($css)->toMatch('/html\s*\{\s*scrollbar-color:\s*#8391a7 transparent;/')
            ->and($css)->toMatch('/html\.dark\s*\{\s*scrollbar-color:\s*#64748b transparent;/');
    });

    it('only sets colors, spacing and the group label, never the font', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/sidebar.css');

        expect($css)->not->toContain('font-family')
            ->and($css)->toContain('linear-gradient')
            ->and($css)->toContain('.fi-main-sidebar')
            ->and($css)->toContain('.wp-sidebar-group-label');
    });
});

describe('login page', function () {
    it('puts a blue gradient behind the login card without touching the font', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/login.css');

        expect(FilamentAsset::getStyleHref('login', 'production-priority'))->toBeString()->toContain('login')
            ->and($css)->toContain('.fi-simple-layout')
            ->and($css)->toContain('linear-gradient')
            ->and($css)->not->toContain('font-family');
    });

    it('shows the WEBA ERP logo, with its light version in dark mode', function () {
        $html = $this->get(Filament::getPanel('admin')->getLoginUrl())->assertOk()->getContent();

        expect($html)->toContain('images/logo.svg')
            ->and($html)->toContain('images/logo-dark.svg')
            ->and(file_get_contents(public_path('images/logo.svg')))->toContain('aria-label="WEBA ERP"')
            ->and(file_get_contents(public_path('images/logo-dark.svg')))->toContain('aria-label="WEBA ERP"');
    });
});

describe('profile page', function () {
    it('gives a user that was created without a contact one when it signs in', function () {
        $user = SecurityHelper::authenticateWithPermissions([]);
        $user->forceFill(['partner_id' => null])->saveQuietly();

        event(new Authenticated('web', $user->refresh()));

        expect($user->partner_id)->not->toBeNull()
            ->and(Partner::withoutGlobalScopes()->find($user->partner_id)?->user_id)->toBe($user->id);
    });
});

describe('panel mode', function () {
    it('uses the sidebar for the admin panel and keeps the top menu for the customer panel', function () {
        expect(Filament::getPanel('admin')->hasTopNavigation())->toBeFalse()
            ->and(Filament::getPanel('admin')->getSidebarWidth())->toBe('15.75rem');

        $customer = Filament::getPanels()['customer'] ?? null;

        if ($customer !== null) {
            expect($customer->hasTopNavigation())->toBeTrue();
        }
    });
});

describe('rendered sidebar', function () {
    it('lists every group and every menu item, not only the group of the current page', function () {
        ManufacturingHelper::actingAsAdmin();

        $response = $this->get(WorkPanel::getUrl())->assertOk();

        $entries = sidebarEntries();

        expect($entries)->not->toBeEmpty();

        foreach ($entries as $entry) {
            $response->assertSee($entry['group']);

            foreach ($entry['urls'] as $url) {
                $response->assertSee('href="'.$url.'"', false);
            }
        }
    });

    it('labels each group once', function () {
        ManufacturingHelper::actingAsAdmin();

        $html = $this->get(WorkPanel::getUrl())->assertOk()->getContent();
        $groups = collect(sidebarEntries())->pluck('group');

        expect(substr_count($html, 'class="wp-sidebar-group-label"'))->toBe($groups->count());
    });

    it('marks the page that is open as the active item', function () {
        ManufacturingHelper::actingAsAdmin();

        $html = $this->get(WorkPanel::getUrl())->assertOk()->getContent();

        expect($html)->toMatch('/<li[^>]*class="[^"]*fi-sidebar-item[^"]*fi-active[^"]*"[^>]*>\s*<a[^>]*href="'.preg_quote(WorkPanel::getUrl(), '/').'"/s');
    });

    it('moves between pages without reloading the whole page', function () {
        ManufacturingHelper::actingAsAdmin();

        $html = $this->get(WorkPanel::getUrl())->assertOk()->getContent();

        expect(Filament::getPanel('admin')->hasSpaMode())->toBeTrue()
            ->and($html)->toMatch('/<a[^>]*href="'.preg_quote(ProductionDashboard::getUrl(), '/').'"[^>]*wire:navigate|<a[^>]*wire:navigate[^>]*href="'.preg_quote(ProductionDashboard::getUrl(), '/').'"/s');
    });

    it('gives the open page the class that the scroll script of SupportPlugin looks for', function () {
        ManufacturingHelper::actingAsAdmin();

        $html = $this->get(WorkPanel::getUrl())->assertOk()->getContent();

        expect($html)->toMatch('/<li[^>]*class="[^"]*fi-sidebar-item-active[^"]*"[^>]*>\s*<a[^>]*href="'.preg_quote(WorkPanel::getUrl(), '/').'"/s');
    });

    it('no longer shows the module switcher of the top bar, as the sidebar lists every group', function () {
        ManufacturingHelper::actingAsAdmin();

        $html = $this->get(WorkPanel::getUrl())->assertOk()->getContent();

        expect($html)->not->toContain('fi-topbar-item-btn')
            ->and($html)->not->toContain('grid-template-columns: repeat(3, minmax(0, 1fr))');
    });

    it('shows a user only the entries that user may open', function () {
        $user = SecurityHelper::authenticateWithPermissions([]);
        $user->forceFill(['is_active' => true])->saveQuietly();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $html = $this->get(Help::getUrl())->assertOk()->getContent();

        $allowed = collect(sidebarEntries())->flatMap(fn (array $entry): array => $entry['urls'])->all();

        expect($allowed)->not->toContain(WorkPanel::getUrl());

        foreach ($allowed as $url) {
            expect($html)->toContain('href="'.$url.'"');
        }

        expect($html)->not->toContain('href="'.WorkPanel::getUrl().'"');
    });
});
