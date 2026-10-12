<?php

namespace Weba\ProductionPriority\Support;

/**
 * The work that is still to be done at one work center for the open orders.
 */
final readonly class WorkCenterLoad
{
    public function __construct(
        public int $workCenterId,
        public string $name,
        public float $remainingMinutes,
        public int $orderCount,
        public int $runningCount,
    ) {}

    public function remainingHours(): float
    {
        return round($this->remainingMinutes / 60, 1);
    }
}
