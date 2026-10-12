<?php

namespace Weba\ProductionPriority\Support;

/**
 * The roles of PT. Weba (PRD section 6) and the permissions that each one starts
 * with. The seeder only gives them to a role the first time it creates it, so a
 * change made later in the role editor is never overwritten.
 */
final class ProductionRoles
{
    public const MANAGER = 'Manajer Produksi';

    public const SUPERVISOR = 'Supervisor Produksi';

    public const WAREHOUSE = 'Gudang dan Pembelian';

    public const LEADER = 'Pimpinan';

    private const ORDER = 'manufacturing_manufacturing::order';

    private const WORK_ORDER = 'manufacturing_work::order';

    private const WORK_CENTER = 'manufacturing_work::center';

    private const BILL_OF_MATERIAL = 'manufacturing_bills::of::material';

    /**
     * @return array<string, list<string>> role name => permission names
     */
    public static function definitions(): array
    {
        return [
            self::MANAGER => array_merge(
                self::on(self::ORDER, ['view_any', 'view', 'create', 'update']),
                self::on(self::WORK_ORDER, ['view_any', 'view', 'create', 'update']),
                self::on(self::WORK_CENTER, ['view_any', 'view']),
                self::on(self::BILL_OF_MATERIAL, ['view_any', 'view']),
                self::on('production_priority_criterion', ['view_any', 'view', 'create', 'update', 'reorder']),
                self::on('production_priority_evaluation', ['view_any', 'view', 'create', 'update']),
                self::on('sale_order', ['view_any', 'view']),
                self::on('inventory_quantity', ['view_any', 'view']),
                self::on('purchase_quotation', ['view_any', 'view', 'create']),
                self::dashboards(),
                [Abilities::APPLY_EVALUATION, Abilities::SET_ORDER_ATTRIBUTES, Abilities::EXPORT_REPORT],
            ),

            self::SUPERVISOR => array_merge(
                self::on(self::ORDER, ['view_any', 'view', 'update']),
                self::on(self::WORK_ORDER, ['view_any', 'view', 'update']),
                self::on(self::WORK_CENTER, ['view_any', 'view']),
                self::on('production_priority_evaluation', ['view_any', 'view']),
                [
                    'page_production_priority_work_panel',
                    'page_production_priority_daily_report',
                    'widget_production_priority_late_orders_widget',
                    'widget_production_priority_work_center_load_widget',
                    Abilities::EXPORT_REPORT,
                ],
            ),

            self::WAREHOUSE => array_merge(
                self::on(self::ORDER, ['view_any', 'view']),
                self::on(self::WORK_ORDER, ['view_any', 'view']),
                self::on('inventory_quantity', ['view_any', 'view', 'create', 'update']),
                self::on('inventory_receipt', ['view_any', 'view', 'create', 'update']),
                self::on('inventory_delivery', ['view_any', 'view', 'create', 'update']),
                self::on('inventory_internal', ['view_any', 'view', 'create', 'update']),
                self::on('inventory_move', ['view_any', 'view']),
                self::on('inventory_scrap', ['view_any', 'view', 'create']),
                self::on('inventory_lot', ['view_any', 'view', 'create', 'update']),
                self::on('inventory_product', ['view_any', 'view']),
                self::on('product_product', ['view_any', 'view']),
                self::on('purchase_quotation', ['view_any', 'view', 'create', 'update']),
                self::on('purchase_purchase::order', ['view_any', 'view', 'create', 'update']),
                self::on('purchase_vendor', ['view_any', 'view', 'create', 'update']),
                ['page_production_priority_work_panel'],
            ),

            self::LEADER => array_merge(
                self::on(self::ORDER, ['view_any', 'view']),
                self::on(self::WORK_ORDER, ['view_any', 'view']),
                self::on(self::WORK_CENTER, ['view_any', 'view']),
                self::on('production_priority_criterion', ['view_any', 'view']),
                self::on('production_priority_evaluation', ['view_any', 'view']),
                self::on('sale_order', ['view_any', 'view']),
                self::dashboards(),
                [Abilities::EXPORT_REPORT],
            ),
        ];
    }

    /**
     * @param  list<string>  $actions
     * @return list<string>
     */
    private static function on(string $resource, array $actions): array
    {
        return array_map(fn (string $action): string => $action.'_'.$resource, $actions);
    }

    /**
     * @return list<string>
     */
    private static function dashboards(): array
    {
        return [
            'page_production_priority_work_panel',
            'page_production_priority_production_dashboard',
            'page_production_priority_daily_report',
            'widget_production_priority_late_orders_widget',
            'widget_production_priority_orders_by_status_chart',
            'widget_production_priority_priority_ranking_widget',
            'widget_production_priority_production_stats_widget',
            'widget_production_priority_work_center_load_widget',
        ];
    }
}
