<?php

namespace Weba\ProductionPriority\Services\Reports;

use Illuminate\Database\Eloquent\Collection;
use Weba\ProductionPriority\Filament\Pages\DailyProductionReport;
use Weba\ProductionPriority\Support\ReportTable;
use Weba\ProductionPriority\Support\WorkOrderEfficiency;
use Webkul\Manufacturing\Models\WorkOrder;

/**
 * The work orders of the daily production report, planned against achieved.
 */
class DailyProductionReportBuilder
{
    /**
     * @param  Collection<int, WorkOrder>  $workOrders  with the minutes_in_period column
     */
    public function build(Collection $workOrders, ?string $from, ?string $until): ReportTable
    {
        $workOrders->loadMissing(['manufacturingOrder', 'product', 'workCenter']);

        $rows = $workOrders->map(fn (WorkOrder $workOrder): array => [
            $workOrder->manufacturingOrder?->name,
            $workOrder->product?->name,
            $workOrder->name,
            $workOrder->workCenter?->name,
            $workOrder->state->getLabel(),
            (float) $workOrder->manufacturingOrder?->quantity,
            (float) $workOrder->quantity_produced,
            (float) $workOrder->expected_duration,
            (float) $workOrder->duration,
            WorkOrderEfficiency::of($workOrder),
            (float) $workOrder->getAttribute(DailyProductionReport::MINUTES_IN_PERIOD),
        ])->values()->all();

        $label = fn (string $key): string => __('production-priority::filament/daily-report.table.'.$key);

        return new ReportTable(
            __('production-priority::filament/daily-report.navigation.title'),
            [
                $label('order'), $label('product'), $label('operation'), $label('work-center'), $label('state'),
                $label('target-quantity'), $label('produced-quantity'), $label('planned-minutes'), $label('actual-minutes'),
                $label('efficiency'), $label('minutes-in-period'),
            ],
            $rows,
            [__('production-priority::filament/reports.daily.period', [
                'from'  => $from ?: '...',
                'until' => $until ?: '...',
            ])],
        );
    }
}
