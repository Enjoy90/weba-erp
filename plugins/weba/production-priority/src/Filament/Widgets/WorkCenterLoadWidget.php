<?php

namespace Weba\ProductionPriority\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Weba\ProductionPriority\Services\ProductionOverview;
use Weba\ProductionPriority\Support\DataAccess;
use Weba\ProductionPriority\Support\WorkCenterLoad;

/**
 * Work still to be done per work center. It shows the workload only; it is not
 * compared with the capacity of the work center.
 */
class WorkCenterLoadWidget extends ChartWidget
{
    use HasWidgetShield {
        canView as protected canViewByPermission;
    }

    protected static ?int $sort = 3;

    protected ?string $pollingInterval = '30s';

    protected ?string $maxHeight = '260px';

    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return static::canViewByPermission() && DataAccess::canReadOrders() && DataAccess::canReadWorkOrders();
    }

    protected static function getPagePermission(): ?string
    {
        return 'widget_production_priority_work_center_load_widget';
    }

    public function getHeading(): string|Htmlable|null
    {
        return __('production-priority::filament/production-priority.dashboard.work-center-load.heading');
    }

    public function getDescription(): string|Htmlable|null
    {
        return __('production-priority::filament/production-priority.dashboard.work-center-load.description');
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $loads = app(ProductionOverview::class)->workCenterLoad();

        return [
            'datasets' => [
                [
                    'label'           => __('production-priority::filament/production-priority.dashboard.work-center-load.dataset'),
                    'data'            => $loads->map(fn (WorkCenterLoad $load): float => $load->remainingHours())->all(),
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $loads->map(fn (WorkCenterLoad $load): string => $load->name)->all(),
        ];
    }
}
