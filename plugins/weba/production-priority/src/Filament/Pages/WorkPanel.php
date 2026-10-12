<?php

namespace Weba\ProductionPriority\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Livewire\Attributes\Url;
use Weba\ProductionPriority\Enums\DayPeriod;
use Weba\ProductionPriority\Filament\Actions\ApplyPriorityAction;
use Weba\ProductionPriority\Filament\Actions\RevertPriorityAction;
use Weba\ProductionPriority\Filament\Actions\RunEvaluationAction;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\EvaluationItem;
use Weba\ProductionPriority\Services\OrderProgressService;
use Weba\ProductionPriority\Services\ProductionOverview;
use Weba\ProductionPriority\Services\ProductionStatsCalculator;
use Weba\ProductionPriority\Support\DataAccess;
use Weba\ProductionPriority\Support\OrderProgress;
use Weba\ProductionPriority\Support\WorkCenterLoad;
use Webkul\Manufacturing\Enums\ManufacturingOrderState;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\ManufacturingOrderResource;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Package;
use Webkul\Purchase\Filament\Admin\Clusters\Orders\Resources\QuotationResource;
use Webkul\Support\Enums\NavigationGroup;

/**
 * Task oriented start page for the production planner: what needs attention
 * today, a few key figures, and the details behind them.
 */
class WorkPanel extends Page implements HasTable
{
    use HasPageShield {
        canAccess as protected canAccessByPermission;
    }
    use InteractsWithTable;

    public const TAB_PRIORITY = 'priority';

    public const TAB_WORK_CENTERS = 'work-centers';

    public const TAB_STATUS = 'status';

    public const FILTER_ALL = 'all';

    public const FILTER_ATTENTION = 'attention';

    public const FILTER_PROGRESS = 'progress';

    public const TOP_N = 5;

    public const CHIP_LIMIT = 4;

    public const POLL_INTERVAL = '60s';

    protected static ?string $slug = 'work-panel';

    protected static ?int $navigationSort = -3;

    protected string $view = 'production-priority::filament.pages.work-panel';

    #[Url(as: 'tab')]
    public string $activeTab = self::TAB_PRIORITY;

    #[Url(as: 'show')]
    public string $rowFilter = self::FILTER_ALL;

    public static function canAccess(): bool
    {
        return static::canAccessByPermission() && DataAccess::canReadOrders();
    }

    protected static function getPagePermission(): ?string
    {
        return 'page_production_priority_work_panel';
    }

    public static function getNavigationLabel(): string
    {
        return __('production-priority::filament/work-panel.navigation.title');
    }

    public static function getNavigationGroup(): string|\UnitEnum
    {
        return NavigationGroup::Dashboard;
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return null;
    }

    public function getTitle(): string|Htmlable
    {
        return __('production-priority::filament/work-panel.navigation.title');
    }

    public function getHeading(): string|Htmlable
    {
        return DayPeriod::fromHour((int) now()->format('G'))->greeting((string) auth()->user()?->name);
    }

    public function getSubheading(): string|Htmlable|null
    {
        $stats = $this->overview()->stats();

        return __('production-priority::filament/work-panel.summary', [
            'date'     => now()->translatedFormat('l, j F Y'),
            'late'     => $stats['late'],
            'days'     => ProductionStatsCalculator::DUE_SOON_DAYS,
            'due_soon' => $stats['due_soon'],
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            RunEvaluationAction::make(redirectToEvaluation: false)
                ->after(fn () => $this->forgetOverview()),
        ];
    }

    public function applyPriorityAction(): Action
    {
        return ApplyPriorityAction::make(redirectToEvaluation: false, defaultTopN: self::TOP_N)
            ->arguments(['evaluation' => $this->overview()->latestEvaluation()?->id])
            ->record(fn (array $arguments): ?Evaluation => $this->evaluationOf($arguments))
            ->label(__('production-priority::filament/work-panel.tasks.plan.apply'))
            ->icon(null)
            ->color('primary')
            ->size('sm')
            ->after(fn () => $this->forgetOverview());
    }

    public function revertPriorityAction(): Action
    {
        return RevertPriorityAction::make(redirectToEvaluation: false)
            ->arguments(['evaluation' => $this->overview()->latestEvaluation()?->id])
            ->record(fn (array $arguments): ?Evaluation => $this->evaluationOf($arguments))
            ->outlined()
            ->size('sm')
            ->after(fn () => $this->forgetOverview());
    }

    /**
     * The evaluation the person saw when the button was drawn. Taking "the latest"
     * again when the button is pressed could apply a newer evaluation that was
     * never looked at.
     *
     * @param  array<string, mixed>  $arguments
     */
    protected function evaluationOf(array $arguments): ?Evaluation
    {
        $id = $arguments['evaluation'] ?? null;

        return is_numeric($id) && DataAccess::canReadEvaluations()
            ? Evaluation::query()->find((int) $id)
            : null;
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = in_array($tab, self::tabs(), true) ? $tab : self::TAB_PRIORITY;
    }

    public function setRowFilter(string $filter): void
    {
        $this->rowFilter = in_array($filter, self::rowFilters(), true) ? $filter : self::FILTER_ALL;

        $this->resetPage();
    }

    /**
     * @return list<string>
     */
    public static function tabs(): array
    {
        return [self::TAB_PRIORITY, self::TAB_WORK_CENTERS, self::TAB_STATUS];
    }

    /**
     * @return list<string>
     */
    public static function rowFilters(): array
    {
        return [self::FILTER_ALL, self::FILTER_ATTENTION, self::FILTER_PROGRESS];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => $this->rankingQuery())
            ->columns([
                TextColumn::make('rank')
                    ->label(__('production-priority::filament/work-panel.priority.columns.rank'))
                    ->weight('bold'),

                TextColumn::make('order.name')
                    ->label(__('production-priority::filament/work-panel.priority.columns.order'))
                    ->description(fn (EvaluationItem $record): ?string => $this->orderDescription($record->order))
                    ->placeholder('—'),

                ViewColumn::make('state')
                    ->label(__('production-priority::filament/work-panel.priority.columns.state'))
                    ->view('production-priority::filament.tables.columns.order-state')
                    ->state(fn (EvaluationItem $record): ?array => $this->stateCell($record->order)),

                ViewColumn::make('deadline')
                    ->label(__('production-priority::filament/work-panel.priority.columns.deadline'))
                    ->view('production-priority::filament.tables.columns.deadline')
                    ->state(fn (EvaluationItem $record): ?array => $this->deadlineCell($record->order)),

                ViewColumn::make('progress')
                    ->label(__('production-priority::filament/work-panel.priority.columns.progress'))
                    ->view('production-priority::filament.tables.columns.progress')
                    ->state(fn (EvaluationItem $record): ?float => $this->progressOf($record->order)?->progressPercent),

                TextColumn::make('score')
                    ->label(__('production-priority::filament/work-panel.priority.columns.score'))
                    ->numeric(decimalPlaces: 4),
            ])
            ->recordActions([
                Action::make('open')
                    ->label(__('production-priority::filament/work-panel.priority.open'))
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->size('sm')
                    ->outlined()
                    ->url(fn (EvaluationItem $record): ?string => $record->order
                        ? ManufacturingOrderResource::getUrl('view', ['record' => $record->order])
                        : null)
                    ->visible(fn (EvaluationItem $record): bool => $record->order !== null),
            ])
            ->defaultSort('rank')
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->emptyStateHeading(fn (): string => $this->rowFilter === self::FILTER_ALL
                ? __('production-priority::filament/work-panel.priority.empty')
                : __('production-priority::filament/work-panel.priority.empty-filter'))
            ->emptyStateDescription(fn (): ?string => $this->rowFilter === self::FILTER_ALL
                ? __('production-priority::filament/work-panel.priority.empty-text')
                : null)
            ->emptyStateIcon('heroicon-o-trophy');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $overview = $this->overview();
        $evaluation = $overview->latestEvaluation();
        $stats = $overview->stats();
        $loads = $overview->workCenterLoad();
        $states = $overview->ordersPerState();

        return [
            'currentTab'    => in_array($this->activeTab, self::tabs(), true) ? $this->activeTab : self::TAB_PRIORITY,
            'currentFilter' => in_array($this->rowFilter, self::rowFilters(), true) ? $this->rowFilter : self::FILTER_ALL,
            'pollInterval'  => self::POLL_INTERVAL,
            'tasks'         => [
                'late'     => $this->lateTask($overview),
                'plan'     => $this->planTask($overview, $evaluation),
                'material' => $this->materialTask($overview),
            ],
            'tiles'     => $this->tiles($stats, $overview->remainingWorkHours()),
            'tabCounts' => [
                self::TAB_PRIORITY     => $evaluation?->order_count ?? 0,
                self::TAB_WORK_CENTERS => $loads->count(),
                self::TAB_STATUS       => array_sum($states),
            ],
            'rowFilters'  => self::rowFilters(),
            'workCenters' => $this->workCenterBars($loads),
            'statuses'    => $this->statusSegments($states),
            'footer'      => $this->footer($evaluation),
        ];
    }

    protected function overview(): ProductionOverview
    {
        return app(ProductionOverview::class);
    }

    /**
     * The overview keeps what it loaded for the whole request, so it must be
     * dropped after an action changed the data the page is about to show.
     */
    protected function forgetOverview(): void
    {
        app()->forgetInstance(ProductionOverview::class);
    }

    protected function rankingQuery(): Builder
    {
        return EvaluationItem::query()
            ->where('evaluation_id', $this->overview()->latestEvaluation()?->id ?? 0)
            ->with([
                'order.product',
                'order.uom',
                ...array_map(fn (string $relation): string => 'order.'.$relation, OrderProgressService::RELATIONS),
            ])
            ->when($this->rowFilter === self::FILTER_ATTENTION, fn (Builder $query) => $query
                ->whereIn('manufacturing_order_id', $this->attentionOrderIds()))
            ->when($this->rowFilter === self::FILTER_PROGRESS, fn (Builder $query) => $query
                ->whereHas('order', fn (Builder $order) => $order->where('state', ManufacturingOrderState::PROGRESS->value)));
    }

    /**
     * @return list<int>
     */
    protected function attentionOrderIds(): array
    {
        $overview = $this->overview();

        return $overview->lateOrders()
            ->merge($overview->dueSoonOrders())
            ->pluck('id')
            ->map(fn (mixed $id): int => (int) $id)
            ->all();
    }

    protected function progressOf(?Order $order): ?OrderProgress
    {
        return $order ? app(OrderProgressService::class)->forOrder($order) : null;
    }

    protected function orderDescription(?Order $order): ?string
    {
        if ($order === null) {
            return null;
        }

        return trim(sprintf(
            '%s, %s %s',
            $order->product?->name ?? '—',
            Number::format((float) $order->product_uom_qty, maxPrecision: 2),
            $order->uom?->name ?? '',
        ));
    }

    /**
     * @return array{key: string, label: string}|null
     */
    protected function stateCell(?Order $order): ?array
    {
        if ($order === null) {
            return null;
        }

        return [
            'key'   => str_replace('_', '-', $order->state->value),
            'label' => $order->state->getLabel(),
        ];
    }

    /**
     * @return array{tone: string, icon: string|null, text: string}|null
     */
    protected function deadlineCell(?Order $order): ?array
    {
        $progress = $this->progressOf($order);

        if ($progress === null) {
            return null;
        }

        if ($progress->daysToDeadline === null) {
            return ['tone' => 'plain', 'icon' => null, 'text' => __('production-priority::filament/production-priority.monitoring.time.no-deadline')];
        }

        $days = number_format(abs($progress->daysToDeadline), 1);

        if ($progress->isLate) {
            return [
                'tone' => 'critical',
                'icon' => 'heroicon-m-exclamation-triangle',
                'text' => __('production-priority::filament/production-priority.monitoring.time.late', ['days' => $days]),
            ];
        }

        if (app(ProductionStatsCalculator::class)->isDueSoon($progress)) {
            return [
                'tone' => 'warning',
                'icon' => 'heroicon-m-clock',
                'text' => __('production-priority::filament/production-priority.monitoring.time.left', ['days' => $days]),
            ];
        }

        return ['tone' => 'plain', 'icon' => null, 'text' => $order->deadline_at->translatedFormat('d M Y')];
    }

    /**
     * @return array<string, mixed>
     */
    protected function lateTask(ProductionOverview $overview): array
    {
        $orders = $overview->lateOrders();

        return [
            'count' => $orders->count(),
            'chips' => $this->chips($orders),
            'url'   => OrderMonitoringResource::getUrl('index', ['filters' => ['late' => ['isActive' => true]]]),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function planTask(ProductionOverview $overview, ?Evaluation $evaluation): array
    {
        if ($evaluation === null) {
            return ['state' => 'none', 'count' => 0, 'chips' => $this->chips(collect())];
        }

        if ($evaluation->isApplied()) {
            $items = $overview->appliedItems();

            return [
                'state'      => 'applied',
                'count'      => $items->count(),
                'chips'      => $this->chips($items->map(fn (EvaluationItem $item): ?Order => $item->order)->filter()->values()),
                'applied_by' => $evaluation->applier?->name,
                'applied_at' => $evaluation->applied_at->translatedFormat('d M Y H:i'),
            ];
        }

        $items = $overview->topRanked(self::TOP_N);

        return [
            'state' => 'pending',
            'name'  => $evaluation->name,
            'count' => $items->count(),
            'chips' => $this->chips($items->map(fn (EvaluationItem $item): ?Order => $item->order)->filter()->values()),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function materialTask(ProductionOverview $overview): array
    {
        $orders = $overview->materialShortOrders();
        $largest = $overview->largestMaterialShortage();

        return [
            'count'    => $orders->count(),
            'chips'    => $this->chips($orders),
            'largest'  => $largest ? [
                'product'  => $largest->productName,
                'quantity' => Number::format($largest->shortageQuantity, maxPrecision: 2),
                'unit'     => $largest->uomName,
            ] : null,
            'url' => $this->purchaseRequestUrl(),
        ];
    }

    /**
     * Where a purchase request can be started, or null when the purchase
     * module is not installed or the user may not create one.
     */
    protected function purchaseRequestUrl(): ?string
    {
        if (! Package::isPluginInstalled('purchases') || ! class_exists(QuotationResource::class)) {
            return null;
        }

        return QuotationResource::canCreate() ? QuotationResource::getUrl('create') : null;
    }

    /**
     * @param  Collection<int, Order>  $orders
     * @return array{items: list<array{label: string, url: string}>, more: int}
     */
    protected function chips(Collection $orders): array
    {
        return [
            'items' => $orders
                ->take(self::CHIP_LIMIT)
                ->map(fn (Order $order): array => [
                    'label' => (string) $order->name,
                    'url'   => ManufacturingOrderResource::getUrl('view', ['record' => $order]),
                ])
                ->values()
                ->all(),
            'more' => max(0, $orders->count() - self::CHIP_LIMIT),
        ];
    }

    /**
     * @param  array{total: int, late: int, due_soon: int, average_progress: float, material_short: int}  $stats
     * @return list<array{key: string, label: string, value: string, unit: string, help: string}>
     */
    protected function tiles(array $stats, float $remainingHours): array
    {
        $days = ProductionStatsCalculator::DUE_SOON_DAYS;

        return [
            $this->tile('active', (string) $stats['total']),
            $this->tile('due-soon', (string) $stats['due_soon'], ['days' => $days]),
            $this->tile('progress', Number::format($stats['average_progress'], maxPrecision: 0).'%'),
            $this->tile('workload', Number::format($remainingHours, maxPrecision: 1)),
        ];
    }

    /**
     * @param  array<string, mixed>  $replace
     * @return array{key: string, label: string, value: string, unit: string, help: string}
     */
    protected function tile(string $key, string $value, array $replace = []): array
    {
        return [
            'key'   => $key,
            'label' => __("production-priority::filament/work-panel.stats.{$key}.label", $replace),
            'value' => $value,
            'unit'  => __("production-priority::filament/work-panel.stats.{$key}.unit"),
            'help'  => __("production-priority::filament/work-panel.stats.{$key}.help", $replace),
        ];
    }

    /**
     * @param  Collection<int, WorkCenterLoad>  $loads
     * @return list<array{name: string, hours: string, percent: float, waiting: int, running: int}>
     */
    protected function workCenterBars(Collection $loads): array
    {
        $largest = (float) $loads->max('remainingMinutes');

        return $loads
            ->map(fn ($load): array => [
                'name'    => $load->name,
                'hours'   => Number::format($load->remainingHours(), maxPrecision: 1),
                'percent' => $largest > 0 ? round($load->remainingMinutes / $largest * 100, 1) : 0.0,
                'waiting' => $load->orderCount,
                'running' => $load->runningCount,
            ])
            ->values()
            ->all();
    }

    /**
     * @param  array<string, int>  $states
     * @return list<array{key: string, label: string, count: int, percent: float}>
     */
    protected function statusSegments(array $states): array
    {
        $total = array_sum($states);

        return collect($states)
            ->map(fn (int $count, string $state): array => [
                'key'     => str_replace('_', '-', $state),
                'label'   => ManufacturingOrderState::from($state)->getLabel(),
                'count'   => $count,
                'percent' => $total > 0 ? round($count / $total * 100, 1) : 0.0,
            ])
            ->values()
            ->all();
    }

    /**
     * @return array{text: string, url: string}
     */
    protected function footer(?Evaluation $evaluation): array
    {
        if ($evaluation === null) {
            return [
                'text' => __('production-priority::filament/work-panel.footer.none'),
                'url'  => EvaluationResource::getUrl('index'),
            ];
        }

        return [
            'text' => __('production-priority::filament/work-panel.footer.evaluation', [
                'name' => $evaluation->name,
                'date' => $evaluation->evaluated_at->translatedFormat('d M Y H:i'),
            ]),
            'url' => EvaluationResource::getUrl('view', ['record' => $evaluation]),
        ];
    }
}
