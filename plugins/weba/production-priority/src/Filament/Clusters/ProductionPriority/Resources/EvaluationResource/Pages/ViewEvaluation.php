<?php

namespace Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Weba\ProductionPriority\Filament\Actions\ApplyPriorityAction;
use Weba\ProductionPriority\Filament\Actions\ExportReportAction;
use Weba\ProductionPriority\Filament\Actions\RevertPriorityAction;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Services\Reports\PriorityRankingReportBuilder;
use Weba\ProductionPriority\Support\ReportTable;

class ViewEvaluation extends ViewRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function resolveRecord(int|string $key): Model
    {
        return static::getResource()::getEloquentQuery()
            ->findOrFail($key)
            ->concealUnseenOrders();
    }

    protected function getHeaderActions(): array
    {
        return [
            ...ExportReportAction::all(fn (): ReportTable => app(PriorityRankingReportBuilder::class)->build($this->getRecord())),
            ApplyPriorityAction::make(),
            RevertPriorityAction::make(),
        ];
    }
}
