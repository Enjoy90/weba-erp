<?php

namespace Weba\ProductionPriority\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Weba\ProductionPriority\Support\ReportTable;

/**
 * Writes a report as a sheet: the title and details on top, then the table with
 * a bold header row.
 */
class ReportTableExport extends TextOnlyValueBinder implements FromArray, ShouldAutoSize, WithCustomStartCell, WithCustomValueBinder, WithEvents, WithHeadings, WithTitle
{
    public function __construct(protected ReportTable $report) {}

    /**
     * @return list<list<string|int|float|null>>
     */
    public function array(): array
    {
        return $this->report->rows;
    }

    /**
     * @return list<string>
     */
    public function headings(): array
    {
        return $this->report->headings;
    }

    public function title(): string
    {
        return mb_substr(str_replace(['\\', '/', '?', '*', ':', '[', ']'], ' ', $this->report->title), 0, 31);
    }

    public function startCell(): string
    {
        return 'A'.$this->headingRow();
    }

    /**
     * @return array<class-string, callable>
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();

                $sheet->setCellValueExplicit('A1', $this->report->title, DataType::TYPE_STRING);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                foreach ($this->report->details as $index => $detail) {
                    $sheet->setCellValueExplicit('A'.($index + 2), $detail, DataType::TYPE_STRING);
                }

                $headingRow = $this->headingRow();
                $lastColumn = $sheet->getHighestColumn();

                $sheet->getStyle("A{$headingRow}:{$lastColumn}{$headingRow}")->getFont()->setBold(true);
                $sheet->freezePane('A'.($headingRow + 1));
            },
        ];
    }

    protected function headingRow(): int
    {
        return count($this->report->details) + 3;
    }
}
