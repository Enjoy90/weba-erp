<?php

namespace Weba\ProductionPriority\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Carbon\CarbonImmutable;
use Carbon\Exceptions\InvalidFormatException;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Weba\ProductionPriority\Filament\Actions\ExportReportAction;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority;
use Weba\ProductionPriority\Services\Reports\DailyProductionReportBuilder;
use Weba\ProductionPriority\Support\DataAccess;
use Weba\ProductionPriority\Support\ReportTable;
use Weba\ProductionPriority\Support\WorkOrderEfficiency;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\WorkCenter;
use Webkul\Manufacturing\Models\WorkOrder;

/**
 * Daily production report (PRD C1): the work orders that were worked on or
 * finished in a period, with what was planned against what was achieved.
 * The ERP keeps no quantity per day, so the figures to date of each work
 * order are shown next to the minutes that were logged inside the period.
 */
class DailyProductionReport extends Page implements HasTable
{
    use HasPageShield {
        canAccess as protected canAccessByPermission;
    }
    use InteractsWithTable;

    public const MINUTES_IN_PERIOD = 'minutes_in_period';

    protected static ?string $cluster = ProductionPriority::class;

    protected static ?string $slug = 'daily-report';

    protected static ?int $navigationSort = 3;

    protected string $view = 'production-priority::filament.pages.daily-production-report';

    public static function canAccess(): bool
    {
        return static::canAccessByPermission() && DataAccess::canReadOrders() && DataAccess::canReadWorkOrders();
    }

    protected static function getPagePermission(): ?string
    {
        return 'page_production_priority_daily_report';
    }

    public static function getNavigationLabel(): string
    {
        return __('production-priority::filament/daily-report.navigation.title');
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return 'heroicon-o-document-chart-bar';
    }

    public function getTitle(): string|Htmlable
    {
        return __('production-priority::filament/daily-report.navigation.title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('production-priority::filament/daily-report.subheading');
    }

    protected function getHeaderActions(): array
    {
        return [
            ...ExportReportAction::all(function (): ReportTable {
                $period = $this->getTableFilterState('period') ?? [];

                return app(DailyProductionReportBuilder::class)->build(
                    $this->getFilteredSortedTableQuery()->limit(ReportTable::MAX_ROWS)->get(),
                    $this->dateOnly($period['from'] ?? null),
                    $this->dateOnly($period['until'] ?? null),
                );
            }),
        ];
    }

    public function table(Table $table): Table
    {
        $label = fn (string $key): string => __('production-priority::filament/daily-report.table.'.$key);

        return $table
            ->query(WorkOrder::query()->whereHas('manufacturingOrder')->with(['manufacturingOrder', 'product', 'workCenter']))
            ->modifyQueryUsing(fn (Builder $query): Builder => $this->withMinutesInPeriod($query))
            ->columns([
                TextColumn::make('manufacturingOrder.name')
                    ->label($label('order'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('product.name')
                    ->label($label('product'))
                    ->toggleable(),

                TextColumn::make('name')
                    ->label($label('operation'))
                    ->searchable(),

                TextColumn::make('workCenter.name')
                    ->label($label('work-center'))
                    ->sortable(),

                TextColumn::make('state')
                    ->label($label('state'))
                    ->badge(),

                TextColumn::make('manufacturingOrder.quantity')
                    ->label($label('target-quantity'))
                    ->numeric(decimalPlaces: 2),

                TextColumn::make('quantity_produced')
                    ->label($label('produced-quantity'))
                    ->numeric(decimalPlaces: 2)
                    ->summarize(Sum::make('sum')->label($label('total'))->numeric(decimalPlaces: 2)),

                TextColumn::make('expected_duration')
                    ->label($label('planned-minutes'))
                    ->numeric(decimalPlaces: 0)
                    ->summarize($this->finishedTotal($label)),

                TextColumn::make('duration')
                    ->label($label('actual-minutes'))
                    ->numeric(decimalPlaces: 0)
                    ->summarize($this->finishedTotal($label)),

                TextColumn::make('efficiency')
                    ->label($label('efficiency'))
                    ->state(fn (WorkOrder $record): ?float => WorkOrderEfficiency::of($record))
                    ->numeric(decimalPlaces: 0)
                    ->suffix('%')
                    ->placeholder('—'),

                TextColumn::make(self::MINUTES_IN_PERIOD)
                    ->label($label('minutes-in-period'))
                    ->numeric(decimalPlaces: 0)
                    ->placeholder('0'),
            ])
            ->filters([
                Filter::make('period')
                    ->label($label('period'))
                    ->schema([
                        DatePicker::make('from')->label($label('from'))->native(false)->default(today()->toDateString()),
                        DatePicker::make('until')->label($label('until'))->native(false)->default(today()->toDateString()),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $this->limitToPeriod($query, $data['from'] ?? null, $data['until'] ?? null))
                    ->indicateUsing(fn (array $data): array => $this->periodIndicators($data)),

                SelectFilter::make('work_center_id')
                    ->label($label('work-center'))
                    ->options(fn (): array => WorkCenter::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable(),

                SelectFilter::make('state')
                    ->label($label('state'))
                    ->options(WorkOrderState::options())
                    ->multiple(),
            ])
            ->groups([
                Group::make('workCenter.name')
                    ->label($label('work-center'))
                    ->collapsible(),

                Group::make('manufacturingOrder.name')
                    ->label($label('order'))
                    ->collapsible(),
            ])
            ->defaultSort('finished_at', 'desc')
            ->emptyStateHeading($label('empty'))
            ->emptyStateDescription($label('empty-description'));
    }

    /**
     * Planned and actual minutes only add up for work orders that are done,
     * because an unfinished one has its whole plan but only part of its time.
     */
    protected function finishedTotal(callable $label): Sum
    {
        return Sum::make('sum')
            ->label($label('total-finished'))
            ->numeric(decimalPlaces: 0)
            ->query(fn (QueryBuilder $query): QueryBuilder => $query->where('state', WorkOrderState::DONE->value));
    }

    /**
     * Keeps the work orders that had time logged, or were finished, inside the
     * period.
     */
    protected function limitToPeriod(Builder $query, ?string $from, ?string $until): Builder
    {
        [$start, $end] = $this->boundsOf($from, $until);

        return $query->where(fn (Builder $builder) => $builder
            ->whereHas('productivityLogs', fn (Builder $logs) => $this->between($logs, 'started_at', $start, $end))
            ->orWhere(fn (Builder $finished) => $this->between($finished->where('state', WorkOrderState::DONE->value), 'finished_at', $start, $end)));
    }

    /**
     * Adds the minutes logged inside the chosen period, counted like the
     * duration of the work order itself. A filter cannot add a column, because
     * the table applies filters inside a nested condition, so this runs on the
     * table query and reads the filter state.
     */
    protected function withMinutesInPeriod(Builder $query): Builder
    {
        $period = $this->getTableFilterState('period') ?? [];

        [$start, $end] = $this->boundsOf($period['from'] ?? null, $period['until'] ?? null);

        return $query->withSum([
            'productivityLogs as '.self::MINUTES_IN_PERIOD => fn (Builder $logs) => $this->between($logs, 'started_at', $start, $end),
        ], 'duration');
    }

    protected function dateOnly(?string $date): ?string
    {
        return $this->parseDate($date)?->toDateString();
    }

    /**
     * The filter state comes from the browser, so a value that is not a date
     * counts as no date instead of failing the whole page.
     */
    protected function parseDate(mixed $date): ?CarbonImmutable
    {
        if (! is_string($date) || $date === '') {
            return null;
        }

        try {
            return CarbonImmutable::parse($date);
        } catch (InvalidFormatException) {
            return null;
        }
    }

    /**
     * @return array{0: ?CarbonImmutable, 1: ?CarbonImmutable}
     */
    protected function boundsOf(?string $from, ?string $until): array
    {
        return [
            $this->parseDate($from)?->startOfDay(),
            $this->parseDate($until)?->endOfDay(),
        ];
    }

    protected function between(Builder $query, string $column, ?CarbonImmutable $start, ?CarbonImmutable $end): Builder
    {
        return $query
            ->when($start, fn (Builder $builder) => $builder->where($column, '>=', $start))
            ->when($end, fn (Builder $builder) => $builder->where($column, '<=', $end));
    }

    /**
     * @param  array{from?: ?string, until?: ?string}  $data
     * @return list<string>
     */
    protected function periodIndicators(array $data): array
    {
        $from = $data['from'] ?? null;
        $until = $data['until'] ?? null;

        return array_values(array_filter([
            filled($from) ? __('production-priority::filament/daily-report.indicators.from', ['date' => CarbonImmutable::parse($from)->translatedFormat('j M Y')]) : null,
            filled($until) ? __('production-priority::filament/daily-report.indicators.until', ['date' => CarbonImmutable::parse($until)->translatedFormat('j M Y')]) : null,
        ]));
    }
}
