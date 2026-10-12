<?php

namespace Weba\ProductionPriority\Navigation;

use Filament\Facades\Filament;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\CriterionResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource;
use Weba\ProductionPriority\Filament\Pages\DailyProductionReport;
use Weba\ProductionPriority\Filament\Pages\ProductionDashboard;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Webkul\Inventory\Filament\Clusters\Operations\Resources\QuantityResource;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\ManufacturingOrderResource;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\WorkOrderResource;
use Webkul\Purchase\Filament\Admin\Clusters\Orders as PurchaseOrdersCluster;
use Webkul\Support\Enums\NavigationGroup;

/**
 * The groups and items that the sidebar puts first, as in the daily work panel
 * design. Only what the current user may open and what is installed is
 * returned, so the rest of the system never has to check that again.
 */
class SidebarDefinition
{
    /**
     * @return list<array{key: string, absorbs: NavigationGroup, items: list<array{id: string, url: string, consume: bool, label: ?string, icon: string, badge: ?string}>}>
     */
    public function resolve(): array
    {
        $groups = [];

        foreach ($this->definition() as $group) {
            $items = [];

            foreach ($group['items'] as $item) {
                $url = $this->urlOf($item['class'], $item['page']);

                if ($url === null) {
                    continue;
                }

                $items[] = [
                    'id'      => $item['id'],
                    'url'     => $url,
                    'consume' => $item['consume'],
                    'label'   => $item['label'] === null ? null : __($item['label']),
                    'icon'    => $item['icon'],
                    'badge'   => $item['badge'],
                ];
            }

            if ($items !== []) {
                $groups[] = ['key' => $group['key'], 'absorbs' => $group['absorbs'], 'items' => $items];
            }
        }

        return $groups;
    }

    /**
     * Consume items only take over an item that the original menu already shows,
     * so for them a missing class is not an error but a reason to skip.
     *
     * @return list<array{key: string, absorbs: NavigationGroup, items: list<array{id: string, class: class-string, page: ?string, consume: bool, label: ?string, icon: string, badge: ?string}>}>
     */
    protected function definition(): array
    {
        $labels = 'production-priority::filament/sidebar.items.';

        return [
            [
                'key'     => 'dashboard',
                'absorbs' => NavigationGroup::Dashboard,
                'items'   => [
                    ['id' => 'work-panel', 'class' => WorkPanel::class, 'page' => null, 'consume' => true, 'label' => null, 'icon' => 'heroicon-o-home', 'badge' => null],
                    ['id' => 'production-dashboard', 'class' => ProductionDashboard::class, 'page' => null, 'consume' => true, 'label' => $labels.'production-dashboard', 'icon' => 'heroicon-o-chart-bar', 'badge' => null],
                ],
            ],
            [
                'key'     => 'manufacturing',
                'absorbs' => NavigationGroup::Manufacturing,
                'items'   => [
                    ['id' => 'manufacturing-orders', 'class' => ManufacturingOrderResource::class, 'page' => 'index', 'consume' => false, 'label' => $labels.'manufacturing-orders', 'icon' => 'heroicon-o-queue-list', 'badge' => 'late-orders'],
                    ['id' => 'work-orders', 'class' => WorkOrderResource::class, 'page' => 'index', 'consume' => false, 'label' => $labels.'work-orders', 'icon' => 'heroicon-o-cog-6-tooth', 'badge' => null],
                    ['id' => 'saw-results', 'class' => EvaluationResource::class, 'page' => 'index', 'consume' => false, 'label' => $labels.'saw-results', 'icon' => 'heroicon-o-flag', 'badge' => null],
                    ['id' => 'monitoring', 'class' => OrderMonitoringResource::class, 'page' => 'index', 'consume' => false, 'label' => $labels.'monitoring', 'icon' => 'heroicon-o-presentation-chart-line', 'badge' => null],
                    ['id' => 'daily-report', 'class' => DailyProductionReport::class, 'page' => null, 'consume' => false, 'label' => $labels.'daily-report', 'icon' => 'heroicon-o-document-chart-bar', 'badge' => null],
                    ['id' => 'criteria', 'class' => CriterionResource::class, 'page' => 'index', 'consume' => false, 'label' => $labels.'criteria', 'icon' => 'heroicon-o-adjustments-horizontal', 'badge' => null],
                ],
            ],
            [
                'key'     => 'inventory',
                'absorbs' => NavigationGroup::Inventory,
                'items'   => [
                    ['id' => 'stock', 'class' => QuantityResource::class, 'page' => 'index', 'consume' => false, 'label' => $labels.'stock', 'icon' => 'heroicon-o-cube', 'badge' => null],
                    ['id' => 'purchase', 'class' => PurchaseOrdersCluster::class, 'page' => null, 'consume' => true, 'label' => $labels.'purchase', 'icon' => 'heroicon-o-shopping-cart', 'badge' => null],
                ],
            ],
        ];
    }

    /**
     * The address of a page, resource or cluster, or null when the panel does
     * not know it (plugin not installed) or the user may not open it.
     *
     * @param  class-string  $class
     */
    protected function urlOf(string $class, ?string $page): ?string
    {
        $panel = Filament::getCurrentPanel();

        if ($panel === null || ! class_exists($class)) {
            return null;
        }

        $registered = in_array($class, $panel->getResources(), true)
            || in_array($class, $panel->getPages(), true)
            || in_array($class, $panel->getClusters(), true);

        if (! $registered || ! $class::canAccess()) {
            return null;
        }

        return $page === null ? $class::getUrl() : $class::getUrl($page);
    }
}
