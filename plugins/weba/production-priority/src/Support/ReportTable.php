<?php

namespace Weba\ProductionPriority\Support;

use Illuminate\Support\Str;

/**
 * A report as plain rows, so that the Excel file and the PDF show the same thing.
 * Numbers stay numbers so that a spreadsheet can add them up.
 */
final readonly class ReportTable
{
    /**
     * The most rows a report is built from, so that one request cannot ask for
     * the whole database.
     */
    public const MAX_ROWS = 5000;

    /**
     * @param  list<string>  $headings
     * @param  list<list<string|int|float|null>>  $rows
     * @param  list<string>  $details  lines under the title, such as the period
     */
    public function __construct(
        public string $title,
        public array $headings,
        public array $rows,
        public array $details = [],
    ) {}

    public function fileName(string $extension): string
    {
        return Str::slug($this->title).'-'.now()->format('Y-m-d').'.'.$extension;
    }
}
