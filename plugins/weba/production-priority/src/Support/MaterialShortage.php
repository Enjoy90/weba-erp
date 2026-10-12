<?php

namespace Weba\ProductionPriority\Support;

/**
 * The part of one component that the open orders still miss, summed over all
 * of them. Quantities are in the unit of the order lines and are not converted.
 */
final readonly class MaterialShortage
{
    public function __construct(
        public int $productId,
        public string $productName,
        public string $uomName,
        public float $shortageQuantity,
        public int $orderCount,
    ) {}
}
