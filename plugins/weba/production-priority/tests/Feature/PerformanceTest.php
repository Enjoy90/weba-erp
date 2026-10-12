<?php

use Filament\Facades\Filament;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Weba\ProductionPriority\Filament\Widgets\LateOrdersWidget;
use Weba\ProductionPriority\Filament\Widgets\OrdersByStatusChart;
use Weba\ProductionPriority\Filament\Widgets\PriorityRankingWidget;
use Weba\ProductionPriority\Filament\Widgets\ProductionStatsWidget;
use Weba\ProductionPriority\Filament\Widgets\WorkCenterLoadWidget;
use Weba\ProductionPriority\Services\EvaluationService;
use Weba\ProductionPriority\Services\ProductionOverview;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';

/*
 * Targets of the PRD (section 1 and 7): ranking up to 200 open orders within
 * 3 seconds, dashboard pages within 2 seconds, and a number of queries that does
 * not grow with the number of orders. The widgets of the production dashboard load
 * lazily, one request each, so each widget is measured by itself. Orders are copied
 * in the database from one order that was built the normal way, which keeps the
 * setup to a few seconds.
 */

const PERFORMANCE_ORDERS = 200;

const SAW_SECONDS_LIMIT = 3.0;

const PAGE_SECONDS_LIMIT = 2.0;

const DASHBOARD_WIDGETS = [
    ProductionStatsWidget::class,
    OrdersByStatusChart::class,
    WorkCenterLoadWidget::class,
    PriorityRankingWidget::class,
    LateOrdersWidget::class,
];

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

    $this->warehouse = InventoryHelper::warehouse();
    $this->finished = ManufacturingHelper::product();
    $this->component = ManufacturingHelper::product();
    $this->workCenter = ManufacturingHelper::workCenter();
});

/**
 * Builds one confirmed order with a finished and a pending work order, and returns
 * its rows so they can be copied.
 *
 * @return array{order: array<string, mixed>, moves: list<array<string, mixed>>, workOrders: list<array<string, mixed>>}
 */
function perfTemplate(object $test): array
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);
    $order = ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 5));

    ManufacturingHelper::workOrder($order, $test->workCenter, null, ['state' => WorkOrderState::DONE, 'expected_duration' => 60]);
    ManufacturingHelper::workOrder($order, $test->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 90]);

    $rows = fn ($query) => $query->get()->map(fn (object $row): array => Arr::except((array) $row, ['id']))->all();

    return [
        'order'      => Arr::except((array) DB::table('manufacturing_orders')->where('id', $order->id)->first(), ['id']),
        'moves'      => $rows(DB::table('inventories_moves')->where('raw_material_order_id', $order->id)->orWhere('order_id', $order->id)),
        'workOrders' => $rows(DB::table('manufacturing_work_orders')->where('manufacturing_order_id', $order->id)),
    ];
}

/**
 * Adds copies of the template order, spread over the open states and over
 * deadlines from ten days ago to thirty days ahead.
 *
 * @param  array{order: array<string, mixed>, moves: list<array<string, mixed>>, workOrders: list<array<string, mixed>>}  $template
 */
function perfCopyOrders(array $template, int $count, int $firstNumber): void
{
    $states = ['confirmed', 'progress', 'to_close'];

    foreach (range($firstNumber, $firstNumber + $count - 1) as $number) {
        $orderId = DB::table('manufacturing_orders')->insertGetId([
            ...$template['order'],
            'name'        => 'MO/PERF/'.$number,
            'state'       => $states[$number % 3],
            'deadline_at' => now()->addDays(($number % 41) - 10)->toDateTimeString(),
        ]);

        DB::table('inventories_moves')->insert(array_map(fn (array $move): array => [
            ...$move,
            'raw_material_order_id' => $move['raw_material_order_id'] === null ? null : $orderId,
            'order_id'              => $move['order_id'] === null ? null : $orderId,
        ], $template['moves']));

        DB::table('manufacturing_work_orders')->insert(array_map(fn (array $workOrder): array => [
            ...$workOrder,
            'manufacturing_order_id' => $orderId,
        ], $template['workOrders']));

        DB::table('production_priority_order_attributes')->insert([
            'manufacturing_order_id' => $orderId,
            'urgency_level'          => ($number % 5) + 1,
            'order_value'            => 1_000_000 + $number * 10_000,
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);
    }
}

/**
 * Seconds that one request for the page takes. The overview keeps its data for
 * the length of a request, and a test lives longer than that, so it starts fresh.
 */
function perfSecondsFor(object $test, string $url): float
{
    app()->forgetInstance(ProductionOverview::class);

    $start = hrtime(true);
    $test->get($url)->assertOk();

    return (hrtime(true) - $start) / 1e9;
}

/**
 * The number of queries of one request for the page.
 */
function perfQueriesFor(object $test, string $url): int
{
    app()->forgetInstance(ProductionOverview::class);

    $terminating = new ReflectionProperty(app(), 'terminatingCallbacks');
    $terminating->setValue(app(), []);

    DB::flushQueryLog();
    DB::enableQueryLog();
    $test->get($url)->assertOk();
    $count = count(DB::getQueryLog());
    DB::disableQueryLog();

    return $count;
}

/**
 * Seconds that each dashboard widget takes to render, as its own request.
 *
 * @return array<class-string, float>
 */
function perfWidgetSeconds(): array
{
    $seconds = [];

    foreach (DASHBOARD_WIDGETS as $widget) {
        app()->forgetInstance(ProductionOverview::class);

        $start = hrtime(true);
        Livewire::test($widget)->assertSuccessful();
        $seconds[$widget] = (hrtime(true) - $start) / 1e9;
    }

    return $seconds;
}

/**
 * The number of queries that all dashboard widgets together run.
 */
function perfWidgetQueries(): int
{
    DB::flushQueryLog();
    DB::enableQueryLog();
    perfWidgetSeconds();
    $count = count(DB::getQueryLog());
    DB::disableQueryLog();

    return $count;
}

it('ranks 200 open orders within three seconds', function () {
    $template = perfTemplate($this);
    perfCopyOrders($template, PERFORMANCE_ORDERS - 1, 1);

    $start = hrtime(true);
    $evaluation = app(EvaluationService::class)->run();
    $seconds = (hrtime(true) - $start) / 1e9;

    expect($evaluation->order_count)->toBe(PERFORMANCE_ORDERS)
        ->and($seconds)->toBeLessThan(SAW_SECONDS_LIMIT);
});

it('opens the work panel within two seconds with 200 open orders', function () {
    $template = perfTemplate($this);
    perfSecondsFor($this, WorkPanel::getUrl());

    perfCopyOrders($template, PERFORMANCE_ORDERS - 1, 1);
    app(EvaluationService::class)->run();

    expect(perfSecondsFor($this, WorkPanel::getUrl()))->toBeLessThan(PAGE_SECONDS_LIMIT);
});

it('renders every widget of the production dashboard within two seconds with 200 open orders', function () {
    $template = perfTemplate($this);
    perfWidgetSeconds();

    perfCopyOrders($template, PERFORMANCE_ORDERS - 1, 1);
    app(EvaluationService::class)->run();

    foreach (perfWidgetSeconds() as $widget => $seconds) {
        expect($seconds)->toBeLessThan(PAGE_SECONDS_LIMIT, $widget.' took '.round($seconds, 2).' seconds');
    }
});

it('runs the same number of queries on the work panel for 10 orders as for 200', function () {
    $template = perfTemplate($this);

    perfCopyOrders($template, 9, 1);
    app(EvaluationService::class)->run();
    perfQueriesFor($this, WorkPanel::getUrl());
    $few = perfQueriesFor($this, WorkPanel::getUrl());

    perfCopyOrders($template, PERFORMANCE_ORDERS - 10, 10);
    app(EvaluationService::class)->run();

    expect(perfQueriesFor($this, WorkPanel::getUrl()))->toBe($few);
});

it('runs the same number of queries in the dashboard widgets for 10 orders as for 200', function () {
    $template = perfTemplate($this);

    perfCopyOrders($template, 9, 1);
    app(EvaluationService::class)->run();
    perfWidgetQueries();
    $few = perfWidgetQueries();

    perfCopyOrders($template, PERFORMANCE_ORDERS - 10, 10);
    app(EvaluationService::class)->run();

    expect(perfWidgetQueries())->toBe($few);
});
