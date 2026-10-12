<?php

use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Filament\Pages\ProductionDashboard;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Security\Models\Permission;
use Webkul\Security\Models\Role;
use Webkul\Security\PermissionRegistrar;
use Webkul\Support\Enums\NavigationGroup;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/support/tests/Helpers/SecurityHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';

const WORK_PANEL_PERMISSION = 'page_production_priority_work_panel';

const ORDER_READ_PERMISSION = 'view_any_manufacturing_manufacturing::order';

/**
 * A user made by the factory is not active, and an inactive user is turned away
 * by the panel itself, which would hide what the page permission does.
 */
function activateUser(object $user): object
{
    $user->forceFill(['is_active' => true])->saveQuietly();

    app(PermissionRegistrar::class)->forgetCachedPermissions();

    return $user;
}

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

describe('access', function () {
    it('opens for the administrator', function () {
        ManufacturingHelper::actingAsAdmin();

        expect(WorkPanel::canAccess())->toBeTrue();

        Livewire::test(WorkPanel::class)->assertSuccessful();
    });

    it('opens for a user who has the page permission', function () {
        activateUser(SecurityHelper::authenticateWithPermissions([WORK_PANEL_PERMISSION, ORDER_READ_PERMISSION]));

        expect(WorkPanel::canAccess())->toBeTrue();

        Livewire::test(WorkPanel::class)->assertSuccessful()->assertSeeHtml('wp-root');
    });

    it('is refused for a user without the page permission', function () {
        activateUser(SecurityHelper::authenticateWithPermissions([]));

        expect(WorkPanel::canAccess())->toBeFalse()
            ->and(WorkPanel::shouldRegisterNavigation())->toBeFalse();

        Livewire::test(WorkPanel::class)->assertForbidden();
    });

    it('is not opened by the permission of the old dashboard', function () {
        activateUser(SecurityHelper::authenticateWithPermissions(['page_production_priority_production_dashboard', ORDER_READ_PERMISSION]));

        expect(ProductionDashboard::canAccess())->toBeTrue()
            ->and(WorkPanel::canAccess())->toBeFalse();
    });

    it('is registered in the admin panel', function () {
        expect(Filament::getPanel('admin')->getPages())->toContain(WorkPanel::class);
    });
});

describe('full page', function () {
    it('is served inside the admin layout with its stylesheet', function () {
        ManufacturingHelper::actingAsAdmin();

        $this->get(WorkPanel::getUrl())
            ->assertOk()
            ->assertSee('wp-root', false)
            ->assertSee('work-panel.css', false)
            ->assertSee('Daily Work Panel');
    });

    it('answers 403 over HTTP for a user without the page permission', function () {
        activateUser(SecurityHelper::authenticateWithPermissions([]));

        $this->get(WorkPanel::getUrl())->assertForbidden();
    });
});

describe('navigation', function () {
    it('sits in the dashboard group above the old dashboard', function () {
        ManufacturingHelper::actingAsAdmin();

        expect(WorkPanel::getNavigationGroup())->toBe(NavigationGroup::Dashboard)
            ->and(WorkPanel::getNavigationSort())->toBeLessThan(ProductionDashboard::getNavigationSort() ?? PHP_INT_MAX)
            ->and(WorkPanel::shouldRegisterNavigation())->toBeTrue()
            ->and(WorkPanel::getSlug())->toBe('work-panel');
    });

    it('is labelled in both languages', function () {
        ManufacturingHelper::actingAsAdmin();

        App::setLocale('id');
        $indonesian = WorkPanel::getNavigationLabel();

        App::setLocale('en');
        $english = WorkPanel::getNavigationLabel();

        expect($indonesian)->toBe('Panel Kerja Harian')
            ->and($english)->toBe('Daily Work Panel')
            ->and((new WorkPanel)->getTitle())->toBe($english);
    });
});

describe('styles', function () {
    it('takes the accent blue from the primary color of the panel', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/work-panel.css');

        expect($css)->toContain('--wp-blue-600: var(--primary-600);')
            ->and($css)->toContain('--wp-blue-600: var(--primary-400);');
    });

    it('registers the stylesheet of the panel', function () {
        $href = FilamentAsset::getStyleHref('work-panel', 'production-priority');

        expect($href)->toBeString()->toContain('work-panel');
    });

    it('defines the colors for the light and the dark theme', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/work-panel.css');

        preg_match_all('/--wp-[a-z0-9-]+(?=:)/', explode('.dark .wp-root', $css)[0], $light);
        preg_match_all('/--wp-[a-z0-9-]+(?=:)/', explode('.dark .wp-root', $css)[1], $dark);

        expect($light[0])->not->toBeEmpty()
            ->and(array_diff($light[0], $dark[0]))->toBe([]);
    });
});

describe('permission migration', function () {
    it('hands the page permission to every role that may open the old dashboard', function () {
        $planner = Role::query()->create(['name' => 'Perencana uji', 'guard_name' => 'web']);
        $outsider = Role::query()->create(['name' => 'Tanpa dashboard uji', 'guard_name' => 'web']);

        $planner->givePermissionTo(Permission::query()->firstOrCreate([
            'name'       => 'page_production_priority_production_dashboard',
            'guard_name' => 'web',
        ]));

        Permission::query()->where('name', WORK_PANEL_PERMISSION)->delete();

        (require __DIR__.'/../../database/migrations/2026_10_09_000001_grant_work_panel_permission.php')->up();

        expect($planner->permissions()->where('name', WORK_PANEL_PERMISSION)->exists())->toBeTrue()
            ->and($outsider->permissions()->where('name', WORK_PANEL_PERMISSION)->exists())->toBeFalse();
    });

    it('can run again without doubling anything', function () {
        $migration = require __DIR__.'/../../database/migrations/2026_10_09_000001_grant_work_panel_permission.php';

        $migration->up();
        $migration->up();

        expect(Permission::query()->where('name', WORK_PANEL_PERMISSION)->where('guard_name', 'web')->count())->toBe(1);
    });
});
