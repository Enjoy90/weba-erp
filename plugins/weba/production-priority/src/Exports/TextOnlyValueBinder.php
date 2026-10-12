<?php

namespace Weba\ProductionPriority\Exports;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

/**
 * Names in a report come from users (products, customers, notes). The default
 * binder turns a text that starts with "=" into a formula, which would run in the
 * spreadsheet of whoever opens the file. Here such a text stays text.
 */
class TextOnlyValueBinder extends DefaultValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value) && str_starts_with($value, '=')) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
