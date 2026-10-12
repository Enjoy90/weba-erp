<?php

use Filament\Facades\Filament;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Navigation\ClusterSubMenu;
use Webkul\Inventory\Filament\Clusters\Operations as InventoryOperations;
use Webkul\Inventory\Filament\Clusters\Operations\Resources\QuantityResource;
use Webkul\Manufacturing\Filament\Clusters\Configurations as ManufacturingConfigurations;
use Webkul\Manufacturing\Filament\Clusters\Configurations\Resources\WorkCenterResource;
use Webkul\Manufacturing\Filament\Clusters\Operations as ManufacturingOperations;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\ManufacturingOrderResource;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Support\Filament\Clusters\Settings;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
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

    ManufacturingHelper::actingAsAdmin();
});

describe('which cluster lists move into the sidebar', function () {
    it('moves a list without headings or with a single heading', function () {
        $subMenu = app(ClusterSubMenu::class);

        expect($subMenu->flatItems(ManufacturingOperations::class))->not->toBeNull()
            ->and($subMenu->flatItems(ManufacturingConfigurations::class))->not->toBeNull();
    });

    it('keeps a list with several headings in the page, because the items could not be told apart without them', function () {
        $subMenu = app(ClusterSubMenu::class);

        expect($subMenu->flatItems(InventoryOperations::class))->toBeNull()
            ->and($subMenu->flatItems(Settings::class))->toBeNull();
    });

    it('never moves the list of a single record', function () {
        $page = new class
        {
            use InteractsWithRecord;

            public static function getCluster(): string
            {
                return ManufacturingOperations::class;
            }
        };

        expect(app(ClusterSubMenu::class)->movesToSidebar($page))->toBeFalse();
    });
});

describe('pages', function () {
    it('leaves out the cluster box when every page of the cluster is already a shortcut', function () {
        $html = $this->get(ManufacturingOrderResource::getUrl('index'))->assertOk()->getContent();

        expect($html)->not->toContain('fi-page-sub-navigation-sidebar-ctn');
    });

    it('shows the other pages of the cluster under the cluster item instead of in a box', function () {
        $html = $this->get(WorkCenterResource::getUrl('index'))->assertOk()->getContent();

        expect($html)->not->toContain('fi-page-sub-navigation-sidebar-ctn')
            ->and($html)->toContain('href="'.WorkCenterResource::getUrl('index').'"')
            ->and($html)->toContain('href="'.ManufacturingConfigurations::getUrl().'"');
    });

    it('keeps the box where the cluster list has several headings', function () {
        $html = $this->get(QuantityResource::getUrl('index'))->assertOk()->getContent();

        expect($html)->toContain('fi-page-sub-navigation-sidebar-ctn');
    });

    it('does not mark a cluster item without children as expandable', function () {
        $html = $this->get(ManufacturingOrderResource::getUrl('index'))->assertOk()->getContent();

        expect($html)->not->toContain('fi-sidebar-sub-group-items');
    });
});
