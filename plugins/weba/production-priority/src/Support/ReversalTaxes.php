<?php

namespace Weba\ProductionPriority\Support;

use Illuminate\Support\Facades\Event;
use Webkul\Account\Models\Move;
use Webkul\Account\Models\MoveLine;

/**
 * A credit note is built by replicating the lines of the invoice it reverses,
 * and replicating a model leaves its many-to-many relations behind. The copied
 * lines therefore lost their taxes and the credit note came out without VAT,
 * leaving the VAT of the invoice unpaid forever. This puts the taxes back on
 * each copied line before the credit note computes its totals.
 */
class ReversalTaxes
{
    /**
     * Sales and purchases use their own subclasses of the move line, and model
     * events carry the exact class name, so the listener watches every model.
     */
    public static function listen(): void
    {
        Event::listen('eloquent.created: *', function (string $event, array $payload): void {
            if (($payload[0] ?? null) instanceof MoveLine) {
                static::copyFromReversedEntry($payload[0]);
            }
        });
    }

    public static function copyFromReversedEntry(MoveLine $line): void
    {
        if (! $line->product_id || $line->tax_line_id) {
            return;
        }

        $reversedEntryId = Move::query()->whereKey($line->move_id)->value('reversed_entry_id');

        if (! $reversedEntryId || $line->taxes()->exists()) {
            return;
        }

        $original = MoveLine::query()
            ->where('move_id', $reversedEntryId)
            ->where('product_id', $line->product_id)
            ->where('display_type', $line->display_type)
            ->where('quantity', $line->quantity)
            ->where('price_unit', $line->price_unit)
            ->with('taxes')
            ->orderBy('id')
            ->first();

        if ($original && $original->taxes->isNotEmpty()) {
            $line->taxes()->sync($original->taxes->modelKeys());
        }
    }
}
