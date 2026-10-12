<?php

namespace Weba\ProductionPriority\Services\Reports;

use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\EvaluationItem;
use Weba\ProductionPriority\Support\ReportTable;

/**
 * The ranking of one saved SAW run with the raw value of every criterion, as it
 * was when the run was made.
 */
class PriorityRankingReportBuilder
{
    public function build(Evaluation $evaluation): ReportTable
    {
        $evaluation->concealUnseenOrders();

        $criteria = collect($evaluation->criteria_snapshot ?? []);

        $headings = [
            __('production-priority::filament/reports.ranking.rank'),
            __('production-priority::filament/reports.ranking.order'),
            __('production-priority::filament/reports.ranking.product'),
            __('production-priority::filament/reports.ranking.deadline'),
            __('production-priority::filament/reports.ranking.score'),
            ...$criteria->map(fn (array $criterion): string => $criterion['code'].' '.$criterion['name'])->all(),
        ];

        $rows = $evaluation->items->map(fn (EvaluationItem $item): array => [
            $item->rank,
            $item->order?->name,
            $item->order?->product?->name,
            $item->order?->deadline_at?->format('Y-m-d H:i'),
            round((float) $item->score, 4),
            ...$criteria->map(fn (array $criterion): ?float => isset($item->raw_values[$criterion['code']]) ? (float) $item->raw_values[$criterion['code']] : null)->all(),
        ])->all();

        return new ReportTable(
            __('production-priority::filament/reports.ranking.title'),
            $headings,
            $rows,
            [
                $evaluation->name.' ('.$evaluation->evaluated_at->format('Y-m-d H:i').')',
                __('production-priority::filament/reports.ranking.weights').': '.$criteria
                    ->map(fn (array $criterion): string => $criterion['code'].' '.number_format((float) $criterion['weight'] * 100, 1).'%')
                    ->implode(', '),
            ],
        );
    }
}
