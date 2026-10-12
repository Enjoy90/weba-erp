<?php

use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority;
use Weba\ProductionPriority\Filament\Pages\DailyProductionReport;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\Order;
use Webkul\Manufacturing\Models\WorkCenterProductivityLog;
use Webkul\Manufacturing\Models\WorkOrder;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Security\PermissionRegistrar;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/support/tests/Helpers/SecurityHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';

/*
 * Daily production report (PRD C1, todo 8.1): work orders that were worked on or
 * finished in a period, planned against achieved. The day is fixed in the tests
 * so that "today" and "yesterday" cannot drift across midnight.
 */

const REPORT_DAY = '2026-10-09';

beforeEach(function () {
    TestBootstrapHelper::ensurePluginInstalled('inventories');
    TestBootstrapHelper::ensurePluginInstalled('manufacturing');
    TestBootstrapHelper::ensurePluginInstalled('production-priority');

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

    Carbon::setTestNow(Carbon::parse(REPORT_DAY.' 12:00:00'));

    $this->warehouse = InventoryHelper::warehouse();
    $this->finished = ManufacturingHelper::product();
    $this->component = ManufacturingHelper::product();
    $this->workCenter = ManufacturingHelper::workCenter();
    $this->otherWorkCenter = ManufacturingHelper::workCenter();
});

afterEach(function () {
    Carbon::setTestNow();
});

function reportOrder(object $test): Order
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);

    return ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 10));
}

/**
 * @param  array<string, mixed>  $overrides
 */
function reportWorkOrder(object $test, array $overrides = [], ?Order $order = null): WorkOrder
{
    return ManufacturingHelper::workOrder($order ?? reportOrder($test), $overrides['work_center'] ?? $test->workCenter, null, array_diff_key($overrides, ['work_center' => true]));
}

function reportLog(WorkOrder $workOrder, float $minutes, string $day = REPORT_DAY): WorkCenterProductivityLog
{
    return WorkCenterProductivityLog::factory()->productive($minutes)->create([
        'work_order_id'  => $workOrder->id,
        'work_center_id' => $workOrder->work_center_id,
        'company_id'     => ManufacturingHelper::company()->id,
        'started_at'     => Carbon::parse($day.' 09:00:00'),
        'finished_at'    => Carbon::parse($day.' 09:00:00')->addMinutes($minutes),
    ]);
}

/**
 * The work order recalculates its duration and finish time when it is saved, so
 * the figures that a test needs are written straight to the table.
 *
 * @param  array<string, mixed>  $columns
 */
function reportSetColumns(WorkOrder $workOrder, array $columns): WorkOrder
{
    DB::table('manufacturing_work_orders')->where('id', $workOrder->id)->update($columns);

    return $workOrder->refresh();
}

describe('rows', function () {
    it('lists the work orders that were worked on today', function () {
        $worked = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        reportLog($worked, 30);

        $untouched = reportWorkOrder($this, ['state' => WorkOrderState::PENDING]);

        Livewire::test(DailyProductionReport::class)
            ->assertCanSeeTableRecords([$worked])
            ->assertCanNotSeeTableRecords([$untouched]);
    });

    it('lists a work order that was finished today even without a log', function () {
        $done = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::DONE]), ['finished_at' => REPORT_DAY.' 16:00:00']);

        Livewire::test(DailyProductionReport::class)->assertCanSeeTableRecords([$done]);
    });

    it('leaves out work that happened on another day', function () {
        $yesterday = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        reportLog($yesterday, 30, '2026-10-08');

        $finishedEarlier = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::DONE]), ['finished_at' => '2026-10-07 10:00:00']);

        Livewire::test(DailyProductionReport::class)
            ->assertCanNotSeeTableRecords([$yesterday, $finishedEarlier]);
    });

    it('follows the period that was chosen', function () {
        $yesterday = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        reportLog($yesterday, 30, '2026-10-08');

        $today = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        reportLog($today, 30);

        Livewire::test(DailyProductionReport::class)
            ->filterTable('period', ['from' => '2026-10-08', 'until' => '2026-10-09'])
            ->assertCanSeeTableRecords([$yesterday, $today])
            ->filterTable('period', ['from' => '2026-10-08', 'until' => '2026-10-08'])
            ->assertCanSeeTableRecords([$yesterday])
            ->assertCanNotSeeTableRecords([$today]);
    });

    it('lists only the work center that was chosen', function () {
        $here = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        $there = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS, 'work_center' => $this->otherWorkCenter]);
        reportLog($here, 30);
        reportLog($there, 30);

        Livewire::test(DailyProductionReport::class)
            ->filterTable('work_center_id', $this->otherWorkCenter->id)
            ->assertCanSeeTableRecords([$there])
            ->assertCanNotSeeTableRecords([$here]);
    });

    it('can be grouped by work center and by order', function () {
        $workOrder = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        reportLog($workOrder, 30);

        foreach (['workCenter.name', 'manufacturingOrder.name'] as $group) {
            Livewire::test(DailyProductionReport::class)
                ->set('tableGrouping', $group)
                ->assertSuccessful()
                ->assertCanSeeTableRecords([$workOrder]);
        }
    });
});

describe('figures', function () {
    it('counts only the minutes logged inside the period', function () {
        $workOrder = reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]);
        reportLog($workOrder, 45);
        reportLog($workOrder, 20, '2026-10-08');

        Livewire::test(DailyProductionReport::class)
            ->assertCanSeeTableRecords([$workOrder])
            ->assertTableColumnStateSet('minutes_in_period', 45.0, $workOrder);
    });

    it('shows the efficiency of a finished work order as planned over actual', function () {
        $workOrder = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::DONE]), [
            'finished_at'       => REPORT_DAY.' 16:00:00',
            'expected_duration' => 60,
            'duration'          => 40,
        ]);

        Livewire::test(DailyProductionReport::class)
            ->assertTableColumnStateSet('efficiency', 150.0, $workOrder);
    });

    it('shows no efficiency for a work order that is not finished or took no time', function () {
        $running = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]), ['expected_duration' => 60, 'duration' => 20]);
        reportLog($running, 20);

        $instant = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::DONE]), ['finished_at' => REPORT_DAY.' 10:00:00', 'expected_duration' => 60, 'duration' => 0]);

        Livewire::test(DailyProductionReport::class)
            ->assertTableColumnStateSet('efficiency', null, $running)
            ->assertTableColumnStateSet('efficiency', null, $instant);
    });

    it('sums planned and actual minutes of finished work orders only', function () {
        $done = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::DONE]), ['finished_at' => REPORT_DAY.' 16:00:00', 'expected_duration' => 60, 'duration' => 40]);
        $running = reportSetColumns(reportWorkOrder($this, ['state' => WorkOrderState::PROGRESS]), ['expected_duration' => 500, 'duration' => 300]);
        reportLog($running, 30);

        Livewire::test(DailyProductionReport::class)
            ->assertCanSeeTableRecords([$done, $running])
            ->assertTableColumnSummarySet('expected_duration', 'sum', 60.0)
            ->assertTableColumnSummarySet('duration', 'sum', 40.0);
    });
});

describe('access', function () {
    it('opens for the administrator and sits in the cluster', function () {
        expect(DailyProductionReport::canAccess())->toBeTrue()
            ->and(DailyProductionReport::getCluster())->toBe(ProductionPriority::class)
            ->and(Filament::getPanel('admin')->getPages())->toContain(DailyProductionReport::class);

        Livewire::test(DailyProductionReport::class)->assertSuccessful();
    });

    it('opens over HTTP inside the admin layout', function () {
        $this->get(DailyProductionReport::getUrl())->assertOk()->assertSee('Daily production report');
    });

    it('is refused for a user without the page permission', function () {
        $user = SecurityHelper::authenticateWithPermissions([]);
        $user->forceFill(['is_active' => true])->saveQuietly();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        expect(DailyProductionReport::canAccess())->toBeFalse();

        Livewire::test(DailyProductionReport::class)->assertForbidden();
    });

    it('opens for a user who has the page permission', function () {
        $user = SecurityHelper::authenticateWithPermissions([
            'page_production_priority_daily_report',
            'view_any_manufacturing_manufacturing::order',
            'view_any_manufacturing_work::order',
        ]);
        $user->forceFill(['is_active' => true])->saveQuietly();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        expect(DailyProductionReport::canAccess())->toBeTrue();

        Livewire::test(DailyProductionReport::class)->assertSuccessful();
    });
});
