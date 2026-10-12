<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Services\EvaluationService;
use Weba\ProductionPriority\Services\ProductionOverview;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;

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

    $this->admin = ManufacturingHelper::actingAsAdmin();

    $this->warehouse = InventoryHelper::warehouse();
    $this->finished = ManufacturingHelper::product();
    $this->component = ManufacturingHelper::product();
    $this->workCenter = ManufacturingHelper::workCenter();
});

/**
 * @param  list<array{0: object, 1: float}>|null  $components
 */
function ovOrder(object $test, ?int $deadlineInDays = 5, bool $confirmed = true, ?array $components = null, float $quantity = 5): Order
{
    $bom = ManufacturingHelper::bom($test->finished, $components ?? [[$test->component, 2]]);
    $order = ManufacturingHelper::order($test->warehouse, $test->finished, $bom, $quantity);

    if ($confirmed) {
        $order = ManufacturingHelper::confirm($order);
    }

    DB::table('manufacturing_orders')->where('id', $order->id)->update([
        'deadline_at' => $deadlineInDays === null ? null : now()->addDays($deadlineInDays),
    ]);

    return $order->refresh();
}

function ovReserve(Order $order, float $quantity, ?int $productId = null): void
{
    DB::table('inventories_moves')
        ->where('raw_material_order_id', $order->id)
        ->when($productId !== null, fn ($query) => $query->where('product_id', $productId))
        ->update(['quantity' => $quantity]);
}

function ovSetState(Order $order, string $state, array $extra = []): void
{
    DB::table('manufacturing_orders')->where('id', $order->id)->update(['state' => $state, ...$extra]);
}

function ovOverview(): ProductionOverview
{
    app()->forgetInstance(ProductionOverview::class);

    return app(ProductionOverview::class);
}

describe('late orders', function () {
    it('lists the open orders past their deadline, the most overdue first', function () {
        $oneDay = ovOrder($this, -1);
        $fiveDays = ovOrder($this, -5);
        $threeDays = ovOrder($this, -3);
        ovOrder($this, 2);
        ovOrder($this, null);
        ovOrder($this, -9, confirmed: false);

        expect(ovOverview()->lateOrders()->pluck('id')->all())->toBe([$fiveDays->id, $threeDays->id, $oneDay->id]);
    });

    it('leaves out finished orders', function () {
        $done = ovOrder($this, -4);
        ovSetState($done, 'done');

        expect(ovOverview()->lateOrders())->toBeEmpty();
    });

    it('matches the late figure of the summary', function () {
        ovOrder($this, -2);
        ovOrder($this, -1);
        ovOrder($this, 4);

        $overview = ovOverview();

        expect($overview->lateOrders())->toHaveCount($overview->stats()['late']);
    });
});

describe('orders due soon', function () {
    it('lists the orders due within three days, the nearest first, without the late ones', function () {
        $two = ovOrder($this, 2);
        $one = ovOrder($this, 1);
        ovOrder($this, 4);
        ovOrder($this, -1);
        ovOrder($this, null);

        expect(ovOverview()->dueSoonOrders()->pluck('id')->all())->toBe([$one->id, $two->id]);
    });

    it('follows the given number of days', function () {
        ovOrder($this, 2);
        $four = ovOrder($this, 4);

        expect(ovOverview()->dueSoonOrders(5)->pluck('id')->all())->toContain($four->id)
            ->and(ovOverview()->dueSoonOrders(3))->toHaveCount(1);
    });

    it('matches the due soon figure of the summary', function () {
        ovOrder($this, 1);
        ovOrder($this, 3);
        ovOrder($this, 6);
        ovOrder($this, -2);

        $overview = ovOverview();

        expect($overview->dueSoonOrders())->toHaveCount($overview->stats()['due_soon']);
    });
});

describe('material shortage', function () {
    it('lists the orders that are not fully reserved, the emptiest first', function () {
        $empty = ovOrder($this);
        $half = ovOrder($this);
        $full = ovOrder($this);

        ovReserve($half, 5);
        ovReserve($full, 10);

        expect(ovOverview()->materialShortOrders()->pluck('id')->all())->toBe([$empty->id, $half->id]);
    });

    it('matches the material shortage figure of the summary', function () {
        ovOrder($this);
        $full = ovOrder($this);
        ovReserve($full, 10);

        $overview = ovOverview();

        expect($overview->materialShortOrders())->toHaveCount($overview->stats()['material_short']);
    });

    it('adds up what is missing per component over the open orders', function () {
        $first = ovOrder($this);
        $second = ovOrder($this);

        ovReserve($second, 4);

        $shortage = ovOverview()->materialShortages()->first();

        expect($shortage->productId)->toBe($this->component->id)
            ->and($shortage->productName)->toBe($this->component->name)
            ->and($shortage->shortageQuantity)->toBe(16.0)
            ->and($shortage->orderCount)->toBe(2)
            ->and($first->refresh()->id)->not->toBe($second->id);
    });

    it('does not count canceled lines or lines that are already reserved', function () {
        $order = ovOrder($this);

        DB::table('inventories_moves')->where('raw_material_order_id', $order->id)->update(['state' => 'canceled']);

        expect(ovOverview()->materialShortages())->toBeEmpty();
    });

    it('puts the component that holds up the most orders first, even when another is missing in a larger quantity', function () {
        $other = ManufacturingHelper::product();

        ovOrder($this);
        ovOrder($this);
        ovOrder($this, components: [[$this->component, 2], [$other, 50]]);

        $shortages = ovOverview()->materialShortages();

        expect($shortages->pluck('productId')->all())->toBe([$this->component->id, $other->id])
            ->and($shortages->first()->orderCount)->toBe(3)
            ->and($shortages->last()->shortageQuantity)->toBe(250.0)
            ->and(ovOverview()->largestMaterialShortage()->productId)->toBe($this->component->id);
    });

    it('has no largest shortage when everything is reserved', function () {
        $order = ovOrder($this);
        ovReserve($order, 10);

        expect(ovOverview()->largestMaterialShortage())->toBeNull();
    });

    it('runs the same number of queries for one order and for many', function () {
        ovOrder($this);

        DB::flushQueryLog();
        DB::enableQueryLog();
        ovOverview()->materialShortages();
        $single = count(DB::getQueryLog());

        collect(range(1, 4))->each(fn () => ovOrder($this));

        DB::flushQueryLog();
        ovOverview()->materialShortages();
        $many = count(DB::getQueryLog());

        DB::disableQueryLog();

        expect($many)->toBe($single);
    });
});

describe('orders waiting to be closed', function () {
    it('counts the orders in the to close state', function () {
        $first = ovOrder($this);
        $second = ovOrder($this);
        ovOrder($this);

        ovSetState($first, 'to_close');
        ovSetState($second, 'to_close');

        expect(ovOverview()->toCloseCount())->toBe(2);
    });

    it('is zero without such orders', function () {
        ovOrder($this);

        expect(ovOverview()->toCloseCount())->toBe(0);
    });
});

describe('work center load', function () {
    it('sums the work left, the running work orders and the orders per work center', function () {
        $order = ovOrder($this);
        $other = ManufacturingHelper::workCenter();

        $running = ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PROGRESS, 'expected_duration' => 120]);
        DB::table('manufacturing_work_orders')->where('id', $running->id)->update(['duration' => 60]);
        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 30]);
        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::DONE, 'expected_duration' => 999]);
        ManufacturingHelper::workOrder($order, $other, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 60]);

        $loads = ovOverview()->workCenterLoad();
        $main = $loads->firstWhere('workCenterId', $this->workCenter->id);

        expect($loads->pluck('workCenterId')->all())->toBe([$this->workCenter->id, $other->id])
            ->and($main->name)->toBe($this->workCenter->name)
            ->and($main->remainingMinutes)->toBe(90.0)
            ->and($main->remainingHours())->toBe(1.5)
            ->and($main->runningCount)->toBe(1)
            ->and($main->orderCount)->toBe(1)
            ->and($loads->last()->runningCount)->toBe(0);
    });

    it('counts an order once per work center however many work orders it has there', function () {
        $order = ovOrder($this);

        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 30]);
        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 30]);
        ManufacturingHelper::workOrder(ovOrder($this), $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 30]);

        expect(ovOverview()->workCenterLoad()->first()->orderCount)->toBe(2);
    });

    it('ignores canceled work, finished work and work without time left', function () {
        $order = ovOrder($this);

        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::CANCEL, 'expected_duration' => 60]);
        $spent = ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PROGRESS, 'expected_duration' => 30]);
        DB::table('manufacturing_work_orders')->where('id', $spent->id)->update(['duration' => 45]);

        expect(ovOverview()->workCenterLoad())->toBeEmpty();
    });

    it('ignores the work of orders that are not open', function () {
        $draft = ovOrder($this, 5, confirmed: false);

        ManufacturingHelper::workOrder($draft, $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 60]);

        expect(ovOverview()->workCenterLoad())->toBeEmpty()
            ->and(ovOverview()->remainingWorkHours())->toBe(0.0);
    });

    it('adds up the remaining hours of all work centers', function () {
        $order = ovOrder($this);

        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 90]);
        ManufacturingHelper::workOrder($order, ManufacturingHelper::workCenter(), null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 60]);

        expect(ovOverview()->remainingWorkHours())->toBe(2.5);
    });
});

describe('orders per state', function () {
    it('lists every state in order, also when there is no order', function () {
        expect(ovOverview()->ordersPerState())->toBe([
            'draft'     => 0,
            'confirmed' => 0,
            'progress'  => 0,
            'to_close'  => 0,
            'done'      => 0,
        ]);
    });

    it('counts the orders per state and leaves out old finished orders', function () {
        ovOrder($this, 5, confirmed: false);
        ovOrder($this);
        ovOrder($this);

        $recent = ovOrder($this);
        $old = ovOrder($this);

        ovSetState($recent, 'done', ['finished_at' => now()->subDays(2)]);
        ovSetState($old, 'done', ['finished_at' => now()->subDays(ProductionOverview::DONE_WINDOW_DAYS + 30)]);

        $counts = ovOverview()->ordersPerState();

        expect($counts['draft'])->toBe(1)
            ->and($counts['confirmed'])->toBe(2)
            ->and($counts['done'])->toBe(1);
    });
});

describe('latest evaluation', function () {
    it('has nothing before the first evaluation', function () {
        $overview = ovOverview();

        expect($overview->latestEvaluation())->toBeNull()
            ->and($overview->topRanked())->toBeEmpty();
    });

    it('returns the newest evaluation together with the user who applied it', function () {
        ovOrder($this);

        Evaluation::factory()->create(['name' => 'Lama', 'evaluated_at' => now()->subDay()]);

        $latest = app(EvaluationService::class)->run();
        $latest->update(['applied_at' => now(), 'applied_by' => Auth::id(), 'applied_top_n' => 1]);

        $evaluation = ovOverview()->latestEvaluation();

        DB::flushQueryLog();
        DB::enableQueryLog();
        $applier = $evaluation->applier->name;
        $queries = count(DB::getQueryLog());
        DB::disableQueryLog();

        expect($evaluation->id)->toBe($latest->id)
            ->and($evaluation->isApplied())->toBeTrue()
            ->and($applier)->toBe($this->admin->name)
            ->and($queries)->toBe(0);
    });

    it('reads the evaluation only once', function () {
        ovOrder($this);
        app(EvaluationService::class)->run();

        $overview = ovOverview();

        expect($overview->latestEvaluation())->toBe($overview->latestEvaluation());
    });

    it('lists the best ranked items first and limits them', function () {
        collect(range(1, 4))->each(fn (int $days) => ovOrder($this, $days));

        app(EvaluationService::class)->run();

        $overview = ovOverview();
        $items = $overview->topRanked(2);

        DB::flushQueryLog();
        DB::enableQueryLog();
        $products = $items->map(fn ($item): string => $item->order->product->name)->all();
        $queries = count(DB::getQueryLog());
        DB::disableQueryLog();

        expect($items->pluck('rank')->all())->toBe([1, 2])
            ->and($products)->toHaveCount(2)
            ->and($queries)->toBe(0)
            ->and($overview->topRanked(2))->toBe($items);
    });
});
