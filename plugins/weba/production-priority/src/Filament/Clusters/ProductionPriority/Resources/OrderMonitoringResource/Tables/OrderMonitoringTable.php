<?php

namespace Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource\Tables;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Weba\ProductionPriority\Enums\OrderValueSource;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\EvaluationItem;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Services\EvaluationService;
use Weba\ProductionPriority\Services\OrderProgressService;
use Weba\ProductionPriority\Services\OrderValueResolver;
use Weba\ProductionPriority\Support\Abilities;
use Weba\ProductionPriority\Support\DataAccess;
use Weba\ProductionPriority\Support\OrderProgress;
use Weba\ProductionPriority\Support\OrderValue;
use Webkul\Manufacturing\Enums\ManufacturingOrderPriority;
use Webkul\Manufacturing\Enums\ManufacturingOrderState;
use Webkul\Manufacturing\Models\Order;
use Webkul\Sale\Enums\OrderState as SaleOrderState;
use Webkul\Sale\Models\Order as SaleOrder;

class OrderMonitoringTable
{
    /**
     * @var array<int, OrderProgress>
     */
    protected static array $progress = [];

    /**
     * @var array<int, EvaluationItem>|null
     */
    protected static ?array $latestRanking = null;

    public static function configure(Table $table): Table
    {
        static::$progress = [];
        static::$latestRanking = null;

        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.order'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('product.name')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.product'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('state')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.state'))
                    ->badge(),

                TextColumn::make('priority')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.priority'))
                    ->badge(),

                TextColumn::make('deadline_at')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.deadline'))
                    ->dateTime()
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('time_status')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.time-status'))
                    ->state(fn (Order $record): string => static::timeStatus(static::progress($record)))
                    ->badge()
                    ->color(fn (Order $record): string => static::timeStatusColor(static::progress($record))),

                TextColumn::make('progress_percent')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.progress'))
                    ->state(fn (Order $record): float => static::progress($record)->progressPercent)
                    ->numeric(decimalPlaces: 0)
                    ->suffix('%')
                    ->badge()
                    ->color(fn (Order $record): string => static::percentColor(static::progress($record)->progressPercent)),

                TextColumn::make('material_percent')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.material'))
                    ->state(fn (Order $record): float => static::progress($record)->materialAvailabilityPercent)
                    ->numeric(decimalPlaces: 0)
                    ->suffix('%')
                    ->badge()
                    ->color(fn (Order $record): string => static::percentColor(static::progress($record)->materialAvailabilityPercent)),

                TextColumn::make('remaining_hours')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.remaining'))
                    ->state(fn (Order $record): float => static::progress($record)->remainingHours())
                    ->numeric(decimalPlaces: 1)
                    ->suffix(' '.__('production-priority::filament/production-priority.monitoring.hours')),

                TextColumn::make('priorityAttribute.urgency_level')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.urgency'))
                    ->placeholder('—')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('order_value')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.order-value'))
                    ->state(fn (Order $record): ?float => static::value($record)->amount)
                    ->numeric(decimalPlaces: 0)
                    ->prefix('Rp ')
                    ->placeholder('—')
                    ->description(fn (Order $record): ?string => static::valueSource(static::value($record)))
                    ->toggleable(),

                TextColumn::make('customer')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.customer'))
                    ->state(fn (Order $record): ?string => static::value($record)->customerName)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('saw_rank')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.saw'))
                    ->state(function (Order $record): string {
                        $item = static::latestRanking()[$record->id] ?? null;

                        return $item
                            ? '#'.$item->rank.' · '.number_format((float) $item->score, 4)
                            : '—';
                    })
                    ->badge()
                    ->color(fn (string $state): string => $state === '—' ? 'gray' : 'primary'),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.state'))
                    ->options(collect(EvaluationService::EVALUATED_STATES)
                        ->mapWithKeys(fn (ManufacturingOrderState $state): array => [$state->value => $state->getLabel()])
                        ->all())
                    ->multiple(),

                SelectFilter::make('priority')
                    ->label(__('production-priority::filament/production-priority.monitoring.table.priority'))
                    ->options(ManufacturingOrderPriority::options()),

                Filter::make('late')
                    ->label(__('production-priority::filament/production-priority.monitoring.filters.late'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('deadline_at')->where('deadline_at', '<', now())),
            ])
            ->recordActions([
                static::editAttributesAction(),
            ])
            ->defaultSort('deadline_at')
            ->poll('60s');
    }

    protected static function editAttributesAction(): Action
    {
        return Action::make('editAttributes')
            ->label(__('production-priority::filament/production-priority.monitoring.actions.attributes.label'))
            ->icon('heroicon-o-adjustments-horizontal')
            ->visible(fn (Order $record): bool => Abilities::allows(Abilities::SET_ORDER_ATTRIBUTES) && Gate::allows('update', $record))
            ->modalHeading(__('production-priority::filament/production-priority.monitoring.actions.attributes.heading'))
            ->fillForm(fn (Order $record): array => [
                'deadline_at'   => $record->deadline_at,
                'urgency_level' => $record->priorityAttribute?->urgency_level ?? OrderAttribute::DEFAULT_URGENCY_LEVEL,
                'order_value'   => $record->priorityAttribute?->order_value,
                'sale_order_id' => $record->priorityAttribute?->sale_order_id,
                'notes'         => $record->priorityAttribute?->notes,
            ])
            ->schema([
                DateTimePicker::make('deadline_at')
                    ->label(__('production-priority::filament/production-priority.monitoring.actions.attributes.deadline'))
                    ->helperText(__('production-priority::filament/production-priority.monitoring.actions.attributes.deadline-help'))
                    ->seconds(false)
                    ->native(false),

                Select::make('urgency_level')
                    ->label(__('production-priority::filament/production-priority.monitoring.actions.attributes.urgency'))
                    ->options(collect(range(OrderAttribute::MIN_URGENCY_LEVEL, OrderAttribute::MAX_URGENCY_LEVEL))
                        ->mapWithKeys(fn (int $level): array => [$level => $level.' · '.__('production-priority::filament/production-priority.monitoring.urgency-levels.'.$level)])
                        ->all())
                    ->required()
                    ->native(false),

                Select::make('sale_order_id')
                    ->label(__('production-priority::filament/production-priority.monitoring.actions.attributes.sale-order'))
                    ->helperText(__('production-priority::filament/production-priority.monitoring.actions.attributes.sale-order-help'))
                    ->visible(fn (): bool => DataAccess::canReadSalesOrders())
                    ->searchable()
                    ->native(false)
                    ->getSearchResultsUsing(fn (string $search): array => static::salesOrderOptions($search))
                    ->getOptionLabelUsing(fn (mixed $value): ?string => static::salesOrderLabelFor($value))
                    ->rule(fn (): Closure => function (string $attribute, mixed $value, Closure $fail): void {
                        if (filled($value) && ! static::linkableSalesOrders()->whereKey($value)->exists()) {
                            $fail(__('production-priority::filament/production-priority.monitoring.actions.attributes.sale-order-invalid'));
                        }
                    }),

                TextInput::make('order_value')
                    ->label(__('production-priority::filament/production-priority.monitoring.actions.attributes.order-value'))
                    ->helperText(__('production-priority::filament/production-priority.monitoring.actions.attributes.order-value-help'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(OrderAttribute::MAX_ORDER_VALUE)
                    ->prefix('Rp'),

                Textarea::make('notes')
                    ->label(__('production-priority::filament/production-priority.monitoring.actions.attributes.notes'))
                    ->rows(2)
                    ->maxLength(1000),
            ])
            ->action(function (array $data, Order $record): void {
                $values = [
                    'urgency_level' => (int) $data['urgency_level'],
                    'order_value'   => filled($data['order_value'] ?? null) ? $data['order_value'] : null,
                    'notes'         => filled($data['notes'] ?? null) ? $data['notes'] : null,
                ];

                if (DataAccess::canReadSalesOrders()) {
                    $values['sale_order_id'] = filled($data['sale_order_id'] ?? null) ? (int) $data['sale_order_id'] : null;
                }

                OrderAttribute::query()->updateOrCreate(['manufacturing_order_id' => $record->id], $values);

                $record->forceFill(['deadline_at' => filled($data['deadline_at'] ?? null) ? $data['deadline_at'] : null])->save();

                Notification::make()
                    ->success()
                    ->title(__('production-priority::filament/production-priority.monitoring.actions.attributes.success'))
                    ->send();
            });
    }

    protected static function progress(Order $order): OrderProgress
    {
        return static::$progress[$order->id] ??= app(OrderProgressService::class)->forOrder($order);
    }

    protected static function value(Order $order): OrderValue
    {
        return app(OrderValueResolver::class)->forOrder($order, DataAccess::canReadSalesOrders());
    }

    protected static function valueSource(OrderValue $value): ?string
    {
        return match ($value->source) {
            OrderValueSource::SALES_ORDER => __('production-priority::filament/production-priority.monitoring.value-source.sales-order', ['order' => $value->salesOrderName]),
            OrderValueSource::MANUAL      => __('production-priority::filament/production-priority.monitoring.value-source.manual'),
            OrderValueSource::UNKNOWN     => null,
        };
    }

    /**
     * Confirmed sales orders that match the text, for the link field.
     *
     * @return array<int, string>
     */
    protected static function salesOrderOptions(string $search): array
    {
        return static::linkableSalesOrders()
            ->with('partner')
            ->where('name', 'like', '%'.$search.'%')
            ->latest('id')
            ->limit(50)
            ->get()
            ->mapWithKeys(fn (SaleOrder $saleOrder): array => [$saleOrder->id => static::salesOrderLabel($saleOrder)])
            ->all();
    }

    /**
     * The sales orders that may be linked: confirmed ones that the user may see.
     *
     * @return Builder<SaleOrder>
     */
    protected static function linkableSalesOrders(): Builder
    {
        return SaleOrder::query()->where('state', SaleOrderState::SALE);
    }

    protected static function salesOrderLabelFor(mixed $id): ?string
    {
        $saleOrder = static::linkableSalesOrders()->with('partner')->find($id);

        return $saleOrder ? static::salesOrderLabel($saleOrder) : null;
    }

    protected static function salesOrderLabel(SaleOrder $saleOrder): string
    {
        return $saleOrder->partner ? $saleOrder->name.' - '.$saleOrder->partner->name : $saleOrder->name;
    }

    /**
     * @return array<int, EvaluationItem>
     */
    protected static function latestRanking(): array
    {
        return static::$latestRanking ??= (function (): array {
            $evaluation = Evaluation::query()->latest('evaluated_at')->latest('id')->first();

            return $evaluation
                ? $evaluation->items()->get()->keyBy('manufacturing_order_id')->all()
                : [];
        })();
    }

    protected static function timeStatus(OrderProgress $progress): string
    {
        if ($progress->daysToDeadline === null) {
            return __('production-priority::filament/production-priority.monitoring.time.no-deadline');
        }

        $days = number_format(abs($progress->daysToDeadline), 1);

        return $progress->isLate
            ? __('production-priority::filament/production-priority.monitoring.time.late', ['days' => $days])
            : __('production-priority::filament/production-priority.monitoring.time.left', ['days' => $days]);
    }

    protected static function timeStatusColor(OrderProgress $progress): string
    {
        return match (true) {
            $progress->daysToDeadline === null => 'gray',
            $progress->isLate                  => 'danger',
            $progress->daysToDeadline <= 3     => 'warning',
            default                            => 'success',
        };
    }

    protected static function percentColor(float $percent): string
    {
        return match (true) {
            $percent >= 67 => 'success',
            $percent >= 34 => 'warning',
            default        => 'danger',
        };
    }
}
