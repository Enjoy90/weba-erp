<?php

namespace Weba\ProductionPriority\Services;

use Weba\ProductionPriority\Enums\OrderValueSource;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Support\OrderValue;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Package;
use Webkul\Sale\Models\Order as SaleOrder;
use Webkul\Sale\Models\OrderLine;

/**
 * Decides what an order is worth for criterion C6. A linked sales order is the
 * record of the sale, so its value comes first. Without one, or when the sales
 * order has no value yet, the value typed in by hand is used.
 */
class OrderValueResolver
{
    public const SALES_PLUGIN = 'sales';

    public function isSalesAvailable(): bool
    {
        return Package::isPluginInstalled(self::SALES_PLUGIN);
    }

    /**
     * The relations of a manufacturing order that this resolver reads.
     *
     * @return list<string>
     */
    public function relations(): array
    {
        if (! $this->isSalesAvailable()) {
            return ['priorityAttribute'];
        }

        return ['priorityAttribute', 'priorityAttribute.saleOrder.lines', 'priorityAttribute.saleOrder.partner'];
    }

    /**
     * @param  bool  $includeSales  false hides the sales order from a viewer who may not read sales orders; the SAW run always includes it
     */
    public function forOrder(Order $order, bool $includeSales = true): OrderValue
    {
        $order->loadMissing($this->relations());

        /** @var OrderAttribute|null $attribute */
        $attribute = $order->priorityAttribute;

        $saleOrder = $includeSales && $this->isSalesAvailable() ? $attribute?->saleOrder : null;
        $salesAmount = $saleOrder ? $this->salesAmount($order, $saleOrder) : null;

        if ($saleOrder && $salesAmount !== null) {
            return new OrderValue($salesAmount, OrderValueSource::SALES_ORDER, $saleOrder->name, $saleOrder->partner?->name);
        }

        $manualAmount = $attribute?->order_value === null ? null : (float) $attribute->order_value;

        return new OrderValue(
            $manualAmount,
            $manualAmount === null ? OrderValueSource::UNKNOWN : OrderValueSource::MANUAL,
            $saleOrder?->name,
            $saleOrder?->partner?->name,
        );
    }

    /**
     * The sold lines of the order's product when the sales order has them, since
     * a sales order may cover several products. Otherwise the untaxed total.
     * Zero counts as unknown: a quotation without prices is not a value.
     */
    protected function salesAmount(Order $order, SaleOrder $saleOrder): ?float
    {
        $productLines = $saleOrder->lines->filter(fn (OrderLine $line): bool => (int) $line->product_id === (int) $order->product_id
            && blank($line->display_type)
            && ! $line->is_downpayment);

        $amount = $productLines->isNotEmpty()
            ? (float) $productLines->sum('price_subtotal')
            : (float) $saleOrder->amount_untaxed;

        return $amount > 0 ? $amount : null;
    }
}
