<?php

namespace Weba\ProductionPriority\Support;

use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\WorkOrder;

final class WorkOrderEfficiency
{
    /**
     * Planned minutes over actual minutes, in percent: above 100 is faster than
     * planned. Only for finished work orders that took time.
     */
    public static function of(WorkOrder $workOrder): ?float
    {
        if ($workOrder->state !== WorkOrderState::DONE || (float) $workOrder->duration <= 0) {
            return null;
        }

        return round((float) $workOrder->expected_duration / (float) $workOrder->duration * 100, 1);
    }
}
