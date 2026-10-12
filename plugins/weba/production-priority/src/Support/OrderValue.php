<?php

namespace Weba\ProductionPriority\Support;

use Weba\ProductionPriority\Enums\OrderValueSource;

final readonly class OrderValue
{
    public function __construct(
        public ?float $amount,
        public OrderValueSource $source,
        public ?string $salesOrderName = null,
        public ?string $customerName = null,
    ) {}
}
