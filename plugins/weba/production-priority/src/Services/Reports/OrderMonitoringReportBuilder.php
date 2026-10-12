<?php

namespace Weba\ProductionPriority\Services\Reports;

use Illuminate\Database\Eloquent\Collection;
use Weba\ProductionPriority\Enums\OrderValueSource;
use Weba\ProductionPriority\Services\OrderProgressService;
use Weba\ProductionPriority\Services\OrderValueResolver;
use Weba\ProductionPriority\Support\DataAccess;
use Weba\ProductionPriority\Support\ReportTable;
use Webkul\Manufacturing\Models\Order;

/**
 * The open orders with their progress, material, urgency and value.
 */
class OrderMonitoringReportBuilder
{
    public function __construct(
        protected OrderProgressService $progressService,
        protected OrderValueResolver $valueResolver,
    ) {}

    /**
     * @param  Collection<int, Order>  $orders
     */
    public function build(Collection $orders): ReportTable
    {
        $orders->loadMissing(['product', ...OrderProgressService::RELATIONS, ...$this->valueResolver->relations()]);

        $progress = $this->progressService->forOrders($orders);

        $includeSales = DataAccess::canReadSalesOrders();

        $rows = $orders->map(function (Order $order) use ($progress, $includeSales): array {
            $value = $this->valueResolver->forOrder($order, $includeSales);

            return [
                $order->name,
                $order->product?->name,
                $order->state->getLabel(),
                $order->priority?->getLabel(),
                $order->deadline_at?->format('Y-m-d H:i'),
                round($progress[$order->id]->progressPercent, 1),
                round($progress[$order->id]->materialAvailabilityPercent, 1),
                $progress[$order->id]->remainingHours(),
                $order->priorityAttribute?->urgency_level,
                $value->amount,
                $value->source === OrderValueSource::UNKNOWN ? null : __('production-priority::filament/reports.monitoring.source.'.$value->source->value),
                $value->customerName,
            ];
        })->values()->all();

        $label = fn (string $key): string => __('production-priority::filament/reports.monitoring.'.$key);

        return new ReportTable(
            $label('title'),
            [
                $label('order'), $label('product'), $label('state'), $label('priority'), $label('deadline'),
                $label('progress'), $label('material'), $label('work-left'), $label('urgency'),
                $label('order-value'), $label('value-source'), $label('customer'),
            ],
            $rows,
            [now()->format('Y-m-d H:i')],
        );
    }
}
