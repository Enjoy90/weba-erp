<?php

namespace Weba\ProductionPriority\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use LogicException;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Services\PriorityApplier;

/**
 * Makes the best ranked orders of an evaluation Urgent. The evaluation is the
 * record of the action, so the caller decides which one it is.
 */
class ApplyPriorityAction
{
    public static function make(bool $redirectToEvaluation = true, int $defaultTopN = 3): Action
    {
        return Action::make('applyPriority')
            ->label(__('production-priority::filament/production-priority.evaluation.actions.apply.label'))
            ->icon('heroicon-o-bolt')
            ->color('danger')
            ->visible(fn (?Model $record): bool => $record instanceof Evaluation && ! $record->isApplied() && Gate::allows('apply', $record))
            ->modalHeading(__('production-priority::filament/production-priority.evaluation.actions.apply.heading'))
            ->modalDescription(__('production-priority::filament/production-priority.evaluation.actions.apply.description'))
            ->schema([
                TextInput::make('top_n')
                    ->label(__('production-priority::filament/production-priority.evaluation.actions.apply.top-n'))
                    ->numeric()
                    ->integer()
                    ->required()
                    ->minValue(1)
                    ->maxValue(fn (Evaluation $record): int => max(1, $record->order_count))
                    ->default(fn (Evaluation $record): int => min($defaultTopN, max(1, $record->order_count))),

                Textarea::make('reason')
                    ->label(__('production-priority::filament/production-priority.evaluation.actions.apply.reason'))
                    ->rows(2)
                    ->maxLength(500),
            ])
            ->action(function (array $data, Evaluation $record, Component $livewire) use ($redirectToEvaluation): void {
                try {
                    $changed = app(PriorityApplier::class)->apply(
                        $record,
                        (int) $data['top_n'],
                        filled($data['reason'] ?? null) ? $data['reason'] : null,
                    );
                } catch (LogicException $exception) {
                    Notification::make()->danger()->title($exception->getMessage())->send();

                    return;
                }

                Notification::make()
                    ->success()
                    ->title(__('production-priority::filament/production-priority.evaluation.actions.apply.success', ['count' => $changed]))
                    ->send();

                if ($redirectToEvaluation) {
                    $livewire->redirect(EvaluationResource::getUrl('view', ['record' => $record]));
                }
            });
    }
}
