<?php

namespace Weba\ProductionPriority\Support;

use Illuminate\Support\Facades\Gate;
use Weba\ProductionPriority\Models\Evaluation;
use Webkul\Manufacturing\Models\Order;
use Webkul\Manufacturing\Models\WorkOrder;
use Webkul\PluginManager\Package;
use Webkul\Sale\Models\Order as SaleOrder;

/**
 * What a page, widget or report needs to read before it may show data. A page
 * permission alone only says the user may open the page: the figures on it come
 * from manufacturing orders, work orders and evaluations, which have their own
 * permissions.
 */
final class DataAccess
{
    public static function canReadOrders(): bool
    {
        return Gate::allows('viewAny', Order::class);
    }

    public static function canReadWorkOrders(): bool
    {
        return Gate::allows('viewAny', WorkOrder::class);
    }

    /**
     * Sales orders belong to the sales plugin, which may not be installed, and
     * show what a customer pays, so they are read only with their own permission.
     */
    public static function canReadSalesOrders(): bool
    {
        return Package::isPluginInstalled('sales') && Gate::allows('viewAny', SaleOrder::class);
    }

    public static function canReadEvaluations(): bool
    {
        return Gate::allows('viewAny', Evaluation::class);
    }
}
