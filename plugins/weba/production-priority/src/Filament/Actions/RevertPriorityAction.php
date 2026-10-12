<?php

namespace Weba\ProductionPriority\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use LogicException;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Services\PriorityApplier;

/**
 * Puts the priorities back as they were before an evaluation was applied.
 */
class RevertPriorityAction
{
    public static function make(bool $redirectToEvaluation = true): Action
    {
        return Action::make('revertPriority')
            ->label(__('production-priority::filament/production-priority.evaluation.actions.revert.label'))
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('gray')
            ->requiresConfirmation()
            ->modalDescription(__('production-priority::filament/production-priority.evaluation.actions.revert.description'))
            ->visible(fn (?Model $record): bool => $record instanceof Evaluation && $record->isApplied() && Gate::allows('apply', $record))
            ->action(function (Evaluation $record, Component $livewire) use ($redirectToEvaluation): void {
                try {
                    $restored = app(PriorityApplier::class)->revert($record);
                } catch (LogicException $exception) {
                    Notification::make()->danger()->title($exception->getMessage())->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title(__('production-priority::filament/production-priority.evaluation.actions.revert.success', ['count' => $restored]))
                    ->send();

                if ($redirectToEvaluation) {
                    $livewire->redirect(EvaluationResource::getUrl('view', ['record' => $record]));
                }
            });
    }
}
