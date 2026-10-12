<?php

namespace Weba\ProductionPriority\Filament\Actions;

use Barryvdh\DomPDF\Facade\Pdf;
use Closure;
use Filament\Actions\Action;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Weba\ProductionPriority\Exports\ReportTableExport;
use Weba\ProductionPriority\Support\Abilities;
use Weba\ProductionPriority\Support\Letterhead;
use Weba\ProductionPriority\Support\ReportTable;

/**
 * Downloads a report as Excel or as PDF with the company letterhead. The page
 * that shows the report decides who may open it, so the action asks for
 * nothing more; it only builds the file from the rows the page hands over.
 */
class ExportReportAction
{
    /**
     * @param  Closure(): ReportTable  $report
     */
    public static function excel(Closure $report): Action
    {
        return Action::make('exportExcel')
            ->label(__('production-priority::filament/reports.actions.excel'))
            ->icon('heroicon-o-table-cells')
            ->color('gray')
            ->visible(fn (): bool => Abilities::allows(Abilities::EXPORT_REPORT))
            ->action(function () use ($report): StreamedResponse {
                $table = $report();

                return response()->streamDownload(
                    fn () => print (Excel::raw(new ReportTableExport($table), ExcelFormat::XLSX)),
                    $table->fileName('xlsx'),
                );
            });
    }

    /**
     * Both downloads, for a page to put in its header.
     *
     * @param  Closure(): ReportTable  $report
     * @return list<Action>
     */
    public static function all(Closure $report): array
    {
        return [static::excel($report), static::pdf($report)];
    }

    /**
     * @param  Closure(): ReportTable  $report
     */
    public static function pdf(Closure $report): Action
    {
        return Action::make('exportPdf')
            ->label(__('production-priority::filament/reports.actions.pdf'))
            ->icon('heroicon-o-document-arrow-down')
            ->color('gray')
            ->visible(fn (): bool => Abilities::allows(Abilities::EXPORT_REPORT))
            ->action(function () use ($report): StreamedResponse {
                $table = $report();

                $pdf = Pdf::loadView('production-priority::pdf.report', [
                    'report'     => $table,
                    'letterhead' => Letterhead::current(),
                    'printedBy'  => (string) auth()->user()?->name,
                    'printedAt'  => now()->format('Y-m-d H:i'),
                ])->setPaper('a4', 'landscape');

                return response()->streamDownload(fn () => print ($pdf->output()), $table->fileName('pdf'));
            });
    }
}
