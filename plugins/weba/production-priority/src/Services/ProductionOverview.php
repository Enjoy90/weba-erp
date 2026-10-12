<?php

namespace Weba\ProductionPriority\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\EvaluationItem;
use Weba\ProductionPriority\Support\DataAccess;
use Weba\ProductionPriority\Support\MaterialShortage;
use Weba\ProductionPriority\Support\OrderProgress;
use Weba\ProductionPriority\Support\WorkCenterLoad;
use Webkul\Inventory\Enums\MoveState;
use Webkul\Manufacturing\Enums\ManufacturingOrderState;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\Order;
use Webkul\Manufacturing\Models\WorkCenter;
use Webkul\Manufacturing\Models\WorkOrder;

/**
 * Loads the open orders once per request so every dashboard widget works on
 * the same data without repeating the queries.
 */
class ProductionOverview
{
    public const DONE_WINDOW_DAYS = 30;

    /**
     * @var Collection<int, Order>|null
     */
    protected ?Collection $orders = null;

    /**
     * @var array<int, OrderProgress>|null
     */
    protected ?array $progress = null;

    /**
     * @var SupportCollection<int, MaterialShortage>|null
     */
    protected ?SupportCollection $materialShortages = null;

    /**
     * @var SupportCollection<int, WorkCenterLoad>|null
     */
    protected ?SupportCollection $workCenterLoad = null;

    /**
     * @var array<string, int>|null
     */
    protected ?array $ordersPerState = null;

    protected bool $evaluationLoaded = false;

    protected ?Evaluation $evaluation = null;

    /**
     * @var array<int, Collection>
     */
    protected array $topRanked = [];

    /**
     * @var Collection<int, EvaluationItem>|null
     */
    protected ?Collection $appliedItems = null;

    public function __construct(
        protected OrderProgressService $progressService,
        protected ProductionStatsCalculator $statsCalculator,
    ) {}

    /**
     * @return Collection<int, Order>
     */
    public function orders(): Collection
    {
        return $this->orders ??= Order::query()
            ->whereIn('state', array_map(
                fn (ManufacturingOrderState $state): string => $state->value,
                EvaluationService::EVALUATED_STATES,
            ))
            ->with(OrderProgressService::RELATIONS)
            ->get();
    }

    /**
     * @return array<int, OrderProgress> keyed by order id
     */
    public function progress(): array
    {
        return $this->progress ??= $this->progressService->forOrders($this->orders());
    }

    /**
     * @return array{total: int, late: int, due_soon: int, average_progress: float, material_short: int}
     */
    public function stats(): array
    {
        return $this->statsCalculator->summarize($this->progress());
    }

    /**
     * Open orders past their deadline, the most overdue first.
     *
     * @return Collection<int, Order>
     */
    public function lateOrders(): Collection
    {
        return $this->orders()
            ->filter(fn (Order $order): bool => $this->progress()[$order->id]->isLate)
            ->sortBy(fn (Order $order): int => $order->deadline_at->getTimestamp())
            ->values();
    }

    /**
     * Open orders that are not late yet but are due within the given days,
     * the nearest deadline first. Uses the same rule as the "due soon" figure.
     *
     * @return Collection<int, Order>
     */
    public function dueSoonOrders(int $days = ProductionStatsCalculator::DUE_SOON_DAYS): Collection
    {
        return $this->orders()
            ->filter(fn (Order $order): bool => $this->statsCalculator->isDueSoon($this->progress()[$order->id], $days))
            ->sortBy(fn (Order $order): int => $order->deadline_at->getTimestamp())
            ->values();
    }

    /**
     * Open orders whose components are not fully reserved, the emptiest first.
     *
     * @return Collection<int, Order>
     */
    public function materialShortOrders(): Collection
    {
        return $this->orders()
            ->filter(fn (Order $order): bool => $this->statsCalculator->isMaterialShort($this->progress()[$order->id]))
            ->sortBy(fn (Order $order): float => $this->progress()[$order->id]->materialAvailabilityPercent)
            ->values();
    }

    /**
     * What the open orders miss per component: demand minus the reserved quantity.
     * The component that holds up the most orders comes first; ties go to the
     * larger quantity. Orders are counted instead of quantities for the ranking
     * because quantities of different units can not be compared.
     *
     * @return SupportCollection<int, MaterialShortage>
     */
    public function materialShortages(): SupportCollection
    {
        return $this->materialShortages ??= $this->buildMaterialShortages();
    }

    public function largestMaterialShortage(): ?MaterialShortage
    {
        return $this->materialShortages()->first();
    }

    public function toCloseCount(): int
    {
        return $this->orders()
            ->filter(fn (Order $order): bool => $order->state === ManufacturingOrderState::TO_CLOSE)
            ->count();
    }

    /**
     * The work that is left per work center for the open orders, the heaviest first.
     *
     * @return SupportCollection<int, WorkCenterLoad>
     */
    public function workCenterLoad(): SupportCollection
    {
        return $this->workCenterLoad ??= $this->buildWorkCenterLoad();
    }

    public function remainingWorkHours(): float
    {
        return round($this->workCenterLoad()->sum('remainingMinutes') / 60, 1);
    }

    /**
     * Number of orders per state. Finished orders are limited to the last
     * DONE_WINDOW_DAYS days so the figure does not grow forever.
     *
     * @return array<string, int> keyed by the value of ManufacturingOrderState
     */
    public function ordersPerState(): array
    {
        return $this->ordersPerState ??= $this->buildOrdersPerState();
    }

    public function latestEvaluation(): ?Evaluation
    {
        if (! $this->evaluationLoaded) {
            $this->evaluation = DataAccess::canReadEvaluations()
                ? Evaluation::query()
                    ->with('applier')
                    ->latest('evaluated_at')
                    ->latest('id')
                    ->first()
                : null;

            $this->evaluationLoaded = true;
        }

        return $this->evaluation;
    }

    /**
     * The best ranked items of the latest evaluation, rank 1 first.
     *
     * @return Collection<int, EvaluationItem>
     */
    public function topRanked(int $limit = 5): Collection
    {
        $evaluation = $this->latestEvaluation();

        if ($evaluation === null) {
            return new Collection;
        }

        return $this->topRanked[$limit] ??= $evaluation->items()
            ->with('order.product')
            ->limit($limit)
            ->get();
    }

    /**
     * The items of the latest evaluation that were made Urgent, best rank first.
     *
     * @return Collection<int, EvaluationItem>
     */
    public function appliedItems(): Collection
    {
        $evaluation = $this->latestEvaluation();

        if ($evaluation === null) {
            return new Collection;
        }

        return $this->appliedItems ??= $evaluation->items()
            ->where('applied', true)
            ->with('order')
            ->get();
    }

    /**
     * @return SupportCollection<int, MaterialShortage>
     */
    protected function buildMaterialShortages(): SupportCollection
    {
        $orders = $this->materialShortOrders();

        $orders->loadMissing(['rawMaterialMoves.product', 'rawMaterialMoves.uom']);

        $rows = [];

        foreach ($orders as $order) {
            foreach ($order->rawMaterialMoves as $move) {
                if (in_array($move->state, [MoveState::CANCELED, MoveState::DONE], true)) {
                    continue;
                }

                $missing = max((float) $move->product_uom_qty - max((float) $move->quantity, 0.0), 0.0);

                if ($missing <= 0.0) {
                    continue;
                }

                $key = $move->product_id.'|'.$move->uom_id;

                $rows[$key] ??= ['move' => $move, 'quantity' => 0.0, 'orders' => []];
                $rows[$key]['quantity'] += $missing;
                $rows[$key]['orders'][$order->id] = true;
            }
        }

        return collect($rows)
            ->map(fn (array $row): MaterialShortage => new MaterialShortage(
                productId: (int) $row['move']->product_id,
                productName: (string) ($row['move']->product?->name ?? '#'.$row['move']->product_id),
                uomName: (string) ($row['move']->uom?->name ?? ''),
                shortageQuantity: round($row['quantity'], 4),
                orderCount: count($row['orders']),
            ))
            ->sort(fn (MaterialShortage $a, MaterialShortage $b): int => [$b->orderCount, $b->shortageQuantity] <=> [$a->orderCount, $a->shortageQuantity])
            ->values();
    }

    /**
     * @return SupportCollection<int, WorkCenterLoad>
     */
    protected function buildWorkCenterLoad(): SupportCollection
    {
        $rows = WorkOrder::query()
            ->selectRaw(
                'work_center_id, '
                .'SUM(CASE WHEN expected_duration > COALESCE(duration, 0) THEN expected_duration - COALESCE(duration, 0) ELSE 0 END) as remaining, '
                .'COUNT(DISTINCT manufacturing_order_id) as order_count, '
                .'SUM(CASE WHEN state = ? THEN 1 ELSE 0 END) as running_count',
                [WorkOrderState::PROGRESS->value],
            )
            ->whereNotIn('state', [WorkOrderState::DONE->value, WorkOrderState::CANCEL->value])
            ->whereHas('manufacturingOrder', fn ($query) => $query->whereIn('state', array_map(
                fn (ManufacturingOrderState $state): string => $state->value,
                EvaluationService::EVALUATED_STATES,
            )))
            ->groupBy('work_center_id')
            ->get()
            ->filter(fn (WorkOrder $row): bool => (float) $row->remaining > 0);

        $names = WorkCenter::query()->whereIn('id', $rows->pluck('work_center_id'))->pluck('name', 'id');

        return $rows
            ->map(fn (WorkOrder $row): WorkCenterLoad => new WorkCenterLoad(
                workCenterId: (int) $row->work_center_id,
                name: (string) ($names[$row->work_center_id] ?? '#'.$row->work_center_id),
                remainingMinutes: (float) $row->remaining,
                orderCount: (int) $row->order_count,
                runningCount: (int) $row->running_count,
            ))
            ->sortByDesc('remainingMinutes')
            ->values();
    }

    /**
     * @return array<string, int>
     */
    protected function buildOrdersPerState(): array
    {
        $states = [
            ManufacturingOrderState::DRAFT,
            ManufacturingOrderState::CONFIRMED,
            ManufacturingOrderState::PROGRESS,
            ManufacturingOrderState::TO_CLOSE,
            ManufacturingOrderState::DONE,
        ];

        $counts = Order::query()
            ->selectRaw('state, COUNT(*) as total')
            ->whereIn('state', array_map(fn (ManufacturingOrderState $state): string => $state->value, $states))
            ->where(function ($query): void {
                $query->where('state', '!=', ManufacturingOrderState::DONE->value)
                    ->orWhere('finished_at', '>=', now()->subDays(self::DONE_WINDOW_DAYS));
            })
            ->groupBy('state')
            ->pluck('total', 'state');

        $result = [];

        foreach ($states as $state) {
            $result[$state->value] = (int) ($counts[$state->value] ?? 0);
        }

        return $result;
    }
}
