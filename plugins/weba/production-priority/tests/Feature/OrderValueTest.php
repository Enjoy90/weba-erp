<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Enums\CriterionSource;
use Weba\ProductionPriority\Enums\OrderValueSource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource\Pages\ListOrderMonitoring;
use Weba\ProductionPriority\Models\Criterion;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Services\CriterionValueResolver;
use Weba\ProductionPriority\Services\OrderValueResolver;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Product\Models\Product;
use Webkul\Sale\Enums\OrderState as SaleOrderState;
use Webkul\Sale\Models\Order as SaleOrder;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';
require_once __DIR__.'/../../../../webkul/sales/tests/Helpers/SaleHelper.php';

/*
 * Criterion C6 (PRD 4.1, todo 4.5 and 8.4). Confirming a sales order does not create
 * a manufacturing order in this ERP, so the link is a field of the order attributes.
 */

beforeEach(function () {
    TestBootstrapHelper::ensurePluginInstalled('inventories');
    TestBootstrapHelper::ensurePluginInstalled('manufacturing');
    TestBootstrapHelper::ensurePluginInstalled('sales');
    TestBootstrapHelper::ensurePluginInstalled('production-priority');

    (new CriterionSeeder)->run();

    foreach (['inventories', 'manufacturing', 'sales', 'production-priority'] as $plugin) {
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
    $this->otherProduct = ManufacturingHelper::product();
    $this->resolver = app(OrderValueResolver::class);
});

function valueOrder(object $test): Order
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);

    return ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 5));
}

/**
 * A confirmed sales order with one line per given product and unit price.
 *
 * @param  array<int, array{0: Product, 1: float, 2: float}>  $lines  product, quantity, unit price
 */
function valueSalesOrder(array $lines): SaleOrder
{
    $saleOrder = SaleHelper::order(['state' => SaleOrderState::SALE]);

    foreach ($lines as [$product, $quantity, $unitPrice]) {
        SaleHelper::line($saleOrder, $product, $quantity, $unitPrice);
    }

    return SaleHelper::compute($saleOrder);
}

function valueLink(Order $order, SaleOrder $saleOrder, ?float $manualValue = null): OrderAttribute
{
    return OrderAttribute::factory()->create([
        'manufacturing_order_id' => $order->id,
        'sale_order_id'          => $saleOrder->id,
        'order_value'            => $manualValue,
    ]);
}

function valueUninstallSales(): void
{
    DB::table('plugins')->where('name', 'sales')->update(['is_installed' => false]);

    Package::$plugins = Plugin::all()->keyBy('name');
}

describe('order value', function () {
    it('is unknown without attributes', function () {
        $value = $this->resolver->forOrder(valueOrder($this));

        expect($value->amount)->toBeNull()
            ->and($value->source)->toBe(OrderValueSource::UNKNOWN)
            ->and($value->salesOrderName)->toBeNull();
    });

    it('is the value typed in by hand without a sales order', function () {
        $order = valueOrder($this);
        OrderAttribute::factory()->orderValue(250000000)->create(['manufacturing_order_id' => $order->id]);

        $value = $this->resolver->forOrder($order->refresh());

        expect($value->amount)->toBe(250000000.0)
            ->and($value->source)->toBe(OrderValueSource::MANUAL);
    });

    it('takes the sold lines of the product from the linked sales order', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([
            [$this->finished, 2, 1500000],
            [$this->finished, 1, 500000],
            [$this->otherProduct, 4, 9000000],
        ]);
        valueLink($order, $saleOrder);

        $value = $this->resolver->forOrder($order->refresh());

        expect($value->amount)->toBe(3500000.0)
            ->and($value->source)->toBe(OrderValueSource::SALES_ORDER)
            ->and($value->salesOrderName)->toBe($saleOrder->name)
            ->and($value->customerName)->toBe($saleOrder->partner->name);
    });

    it('leaves out downpayment lines', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([[$this->finished, 2, 1000000]]);
        $downpayment = SaleHelper::line($saleOrder, $this->finished, 1, 400000);
        $downpayment->update(['is_downpayment' => true]);
        valueLink($order, $saleOrder);

        expect($this->resolver->forOrder($order->refresh())->amount)->toBe(2000000.0);
    });

    it('takes the untaxed total when the sales order has no line of the product', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([[$this->otherProduct, 3, 2000000]]);
        valueLink($order, $saleOrder);

        expect($this->resolver->forOrder($order->refresh())->amount)->toBe(6000000.0);
    });

    it('prefers the sales order over the value typed in by hand', function () {
        $order = valueOrder($this);
        valueLink($order, valueSalesOrder([[$this->finished, 1, 1000000]]), manualValue: 777);

        $value = $this->resolver->forOrder($order->refresh());

        expect($value->amount)->toBe(1000000.0)
            ->and($value->source)->toBe(OrderValueSource::SALES_ORDER);
    });

    it('falls back to the value typed in by hand when the sales order has no value', function () {
        $order = valueOrder($this);
        $emptySaleOrder = valueSalesOrder([]);
        valueLink($order, $emptySaleOrder, manualValue: 777);

        $value = $this->resolver->forOrder($order->refresh());

        expect($value->amount)->toBe(777.0)
            ->and($value->source)->toBe(OrderValueSource::MANUAL)
            ->and($value->salesOrderName)->toBe($emptySaleOrder->name);
    });

    it('ignores a sales order that was deleted', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([[$this->finished, 1, 1000000]]);
        valueLink($order, $saleOrder, manualValue: 777);
        $saleOrder->delete();

        $value = $this->resolver->forOrder($order->refresh());

        expect($value->amount)->toBe(777.0)
            ->and($value->source)->toBe(OrderValueSource::MANUAL);
    });

    it('ignores the link when the sales plugin is not installed', function () {
        $order = valueOrder($this);
        valueLink($order, valueSalesOrder([[$this->finished, 1, 1000000]]), manualValue: 777);

        valueUninstallSales();

        $value = $this->resolver->forOrder($order->refresh());

        expect($this->resolver->isSalesAvailable())->toBeFalse()
            ->and($this->resolver->relations())->toBe(['priorityAttribute'])
            ->and($value->amount)->toBe(777.0)
            ->and($value->source)->toBe(OrderValueSource::MANUAL);
    });

    it('is the C6 value in the decision matrix', function () {
        $order = valueOrder($this);
        valueLink($order, valueSalesOrder([[$this->finished, 2, 1250000]]));

        $criteria = Criterion::withoutGlobalScopes()->where('source', CriterionSource::ORDER_VALUE)->get();

        $matrix = app(CriterionValueResolver::class)->resolve([$order->refresh()], $criteria);

        expect($matrix[$order->id]['C6'])->toBe(2500000.0);
    });
});

describe('order monitoring', function () {
    it('links a sales order from the table', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([[$this->finished, 1, 1000000]]);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 4, 'sale_order_id' => $saleOrder->id])
            ->assertHasNoTableActionErrors();

        expect(OrderAttribute::query()->where('manufacturing_order_id', $order->id)->value('sale_order_id'))->toBe($saleOrder->id);
    });

    it('rejects a sales order that does not exist', function () {
        $order = valueOrder($this);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 4, 'sale_order_id' => 999999])
            ->assertHasTableActionErrors(['sale_order_id']);
    });

    it('removes the link when the field is cleared', function () {
        $order = valueOrder($this);
        valueLink($order, valueSalesOrder([[$this->finished, 1, 1000000]]));

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 4, 'sale_order_id' => null]);

        expect(OrderAttribute::query()->where('manufacturing_order_id', $order->id)->value('sale_order_id'))->toBeNull();
    });

    it('keeps the link when the sales plugin is not installed', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([[$this->finished, 1, 1000000]]);
        valueLink($order, $saleOrder);

        valueUninstallSales();

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 2]);

        expect(OrderAttribute::query()->where('manufacturing_order_id', $order->id)->value('sale_order_id'))->toBe($saleOrder->id);
    });

    it('shows the value, where it comes from and the customer', function () {
        $order = valueOrder($this);
        $saleOrder = valueSalesOrder([[$this->finished, 1, 1000000]]);
        valueLink($order, $saleOrder);

        Livewire::test(ListOrderMonitoring::class)
            ->assertSuccessful()
            ->assertSee('1,000,000')
            ->assertSee(__('production-priority::filament/production-priority.monitoring.value-source.sales-order', ['order' => $saleOrder->name]));
    });

    it('shows a hand typed value as such', function () {
        $order = valueOrder($this);
        OrderAttribute::factory()->orderValue(250000000)->create(['manufacturing_order_id' => $order->id]);

        Livewire::test(ListOrderMonitoring::class)
            ->assertSee('250,000,000')
            ->assertSee(__('production-priority::filament/production-priority.monitoring.value-source.manual'));
    });
});
