<?php

namespace Weba\ProductionPriority\Enums;

enum OrderValueSource: string
{
    case SALES_ORDER = 'sales_order';
    case MANUAL = 'manual';
    case UNKNOWN = 'unknown';
}
