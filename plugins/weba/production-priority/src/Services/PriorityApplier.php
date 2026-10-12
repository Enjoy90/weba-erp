<?php

namespace Weba\ProductionPriority\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;
use LogicException;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\EvaluationItem;
use Webkul\Manufacturing\Enums\ManufacturingOrderPriority;
use Webkul\Manufacturing\Models\Order;

/**
 * Turns the top ranked orders of an evaluation into urgent orders, and undoes it.
 * Only orders whose priority was actually changed are remembered, so reverting
 * never touches an order that somebody else changed afterwards.
 *
 * When a user does this, every order it touches must be one that the user may see
 * and update, otherwise nothing is changed at all: a half applied ranking would
 * be worse than none. Work without a user (the console) is not restricted.
 */
class PriorityApplier
{
    /**
     * @return int number of orders that were changed to urgent
     *
     * @throws LogicException when the evaluation was already applied, is not the latest one,
     *                        changes nothing, or touches an order that the user may not update
     * @throws InvalidArgumentException when the number of orders is below one
     */
    public function apply(Evaluation $evaluation, int $topN, ?string $reason = null): int
    {
        if ($topN < 1) {
            throw new InvalidArgumentException('At least one order must be selected.');
        }

        return DB::transaction(function () use ($evaluation, $topN, $reason): int {
            $evaluation = $this->lockedEvaluation($evaluation);

            if ($evaluation->isApplied()) {
                throw new LogicException('This evaluation was already applied. Revert it first.');
            }

            if (! $this->isLatest($evaluation)) {
                throw new LogicException(__('production-priority::services/priority-applier.not-latest'));
            }

            $items = $evaluation->items()->where('rank', '<=', $topN)->get();

            $orders = $this->visibleOrdersFor($items);

            $this->ensureAllowed($items, $orders, fn (Order $order): bool => $order->priority !== ManufacturingOrderPriority::URGENT);

            $changed = 0;

            foreach ($items as $item) {
                $order = $orders->get($item->manufacturing_order_id);

                if (! $order || $order->priority === ManufacturingOrderPriority::URGENT || ! $this->isStillOpen($order)) {
                    continue;
                }

                $previous = $order->priority?->value ?? ManufacturingOrderPriority::NORMAL->value;

                $order->updateQuietly(['priority' => ManufacturingOrderPriority::URGENT]);

                $item->update(['previous_priority' => $previous, 'applied' => true]);

                $this->note($order, 'applied', $evaluation, $reason, [
                    'rank'  => $item->rank,
                    'score' => $item->score,
                ]);

                $changed++;
            }

            if ($changed === 0) {
                throw new LogicException(__('production-priority::services/priority-applier.nothing-changed'));
            }

            $evaluation->update([
                'applied_at'    => now(),
                'applied_by'    => Auth::id(),
                'applied_top_n' => $topN,
            ]);

            return $changed;
        });
    }

    /**
     * @return int number of orders whose previous priority was restored
     *
     * @throws LogicException when the evaluation was not applied, or touches an order that the user may not update
     */
    public function revert(Evaluation $evaluation): int
    {
        return DB::transaction(function () use ($evaluation): int {
            $evaluation = $this->lockedEvaluation($evaluation);

            if (! $evaluation->isApplied()) {
                throw new LogicException('This evaluation was not applied.');
            }

            $items = $evaluation->items()->where('applied', true)->get();

            $orders = $this->visibleOrdersFor($items);

            $this->ensureAllowed($items, $orders, fn (Order $order): bool => $order->priority === ManufacturingOrderPriority::URGENT);

            $restored = 0;

            foreach ($items as $item) {
                $order = $orders->get($item->manufacturing_order_id);

                if ($order && $order->priority === ManufacturingOrderPriority::URGENT && $this->isStillOpen($order)) {
                    $order->updateQuietly([
                        'priority' => ManufacturingOrderPriority::tryFrom((string) $item->previous_priority) ?? ManufacturingOrderPriority::NORMAL,
                    ]);

                    $this->note($order, 'reverted', $evaluation);

                    $restored++;
                }

                $item->update(['applied' => false]);
            }

            $evaluation->update(['applied_at' => null, 'applied_by' => null, 'applied_top_n' => null]);

            return $restored;
        });
    }

    /**
     * The evaluation as it is now, locked, so two people applying it at the same
     * moment cannot both pass the "already applied" check.
     */
    protected function lockedEvaluation(Evaluation $evaluation): Evaluation
    {
        return Evaluation::query()->lockForUpdate()->findOrFail($evaluation->getKey());
    }

    /**
     * Only the newest evaluation describes the situation as it is; an older one
     * would put orders at the top that no longer belong there.
     */
    protected function isLatest(Evaluation $evaluation): bool
    {
        $latestId = Evaluation::query()
            ->where('company_id', $evaluation->company_id)
            ->latest('evaluated_at')
            ->latest('id')
            ->value('id');

        return $latestId === $evaluation->id;
    }

    /**
     * The orders of the items as the current user sees them: the global scopes of
     * the order (company, ownership) still apply.
     *
     * @param  iterable<EvaluationItem>  $items
     * @return Collection<int, Order>
     */
    protected function visibleOrdersFor(iterable $items): Collection
    {
        return Order::query()->whereIn('id', collect($items)->pluck('manufacturing_order_id'))->get()->keyBy('id');
    }

    /**
     * Stops the whole change when a user is not allowed to change an order that
     * the change needs: one that is hidden from the user or that the user may not
     * update. Orders that need no change are ignored.
     *
     * @param  iterable<EvaluationItem>  $items
     * @param  Collection<int, Order>  $visible
     * @param  callable(Order): bool  $needsChange
     */
    protected function ensureAllowed(iterable $items, Collection $visible, callable $needsChange): void
    {
        $user = Auth::user();

        if ($user === null) {
            return;
        }

        $hiddenIds = collect($items)->pluck('manufacturing_order_id')->diff($visible->keys());

        $hiddenOpen = $hiddenIds->isNotEmpty() && Order::withoutGlobalScopes()
            ->whereIn('id', $hiddenIds)
            ->whereIn('state', array_map(fn ($state) => $state->value, EvaluationService::EVALUATED_STATES))
            ->exists();

        $forbidden = $visible->contains(fn (Order $order): bool => $this->isStillOpen($order)
            && $needsChange($order)
            && Gate::forUser($user)->denies('update', $order));

        if ($hiddenOpen || $forbidden) {
            throw new LogicException(__('production-priority::services/priority-applier.not-allowed'));
        }
    }

    protected function isStillOpen(Order $order): bool
    {
        return in_array($order->state, EvaluationService::EVALUATED_STATES, true);
    }

    /**
     * @param  array<string, mixed>  $replace
     */
    protected function note(Order $order, string $key, Evaluation $evaluation, ?string $reason = null, array $replace = []): void
    {
        $body = __('production-priority::services/priority-applier.'.$key, ['evaluation' => $evaluation->name, ...$replace]);

        if (filled($reason)) {
            $body .= ' '.__('production-priority::services/priority-applier.reason', ['reason' => $reason]);
        }

        $order->addMessage([
            'type'       => 'comment',
            'body'       => $body,
            'company_id' => $order->company_id,
        ]);
    }
}
