<?php

namespace Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Weba\ProductionPriority\Filament\Actions\ExportReportAction;
use Weba\ProductionPriority\Filament\Actions\RunEvaluationAction;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource;
use Weba\ProductionPriority\Services\Reports\OrderMonitoringReportBuilder;
use Weba\ProductionPriority\Support\ReportTable;

class ListOrderMonitoring extends ListRecords
{
    protected static string $resource = OrderMonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...ExportReportAction::all(fn (): ReportTable => app(OrderMonitoringReportBuilder::class)->build($this->getFilteredSortedTableQuery()->limit(ReportTable::MAX_ROWS)->get())),
            RunEvaluationAction::make(),
        ];
    }
}
