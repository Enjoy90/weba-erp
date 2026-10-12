<?php

namespace Weba\ProductionPriority\Navigation;

use Weba\ProductionPriority\Services\EvaluationService;
use Webkul\Manufacturing\Enums\ManufacturingOrderState;
use Webkul\Manufacturing\Models\Order;

/**
 * The number on the production orders menu item: open orders whose deadline has
 * passed. It follows the same rule as the "late" figure of the daily work
 * panel, but costs a single count query because it runs on every page.
 */
class LateOrderBadge
{
    protected ?int $count = null;

    public function count(): int
    {
        return $this->count ??= Order::query()
            ->whereIn('state', array_map(
                fn (ManufacturingOrderState $state): string => $state->value,
                EvaluationService::EVALUATED_STATES,
            ))
            ->whereNotNull('deadline_at')
            ->where('deadline_at', '<', now())
            ->count();
    }

    /**
     * Nothing is shown when no order is late.
     */
    public function label(): ?string
    {
        $count = $this->count();

        return $count > 0 ? (string) $count : null;
    }
}
