@php
    use Illuminate\Support\Number;
    use Weba\ProductionPriority\Filament\Pages\WorkPanel;

    $late = $tasks['late'];
    $plan = $tasks['plan'];
    $material = $tasks['material'];
    $tabLabels = [
        WorkPanel::TAB_PRIORITY => __('production-priority::filament/work-panel.tabs.priority'),
        WorkPanel::TAB_WORK_CENTERS => __('production-priority::filament/work-panel.tabs.work-centers'),
        WorkPanel::TAB_STATUS => __('production-priority::filament/work-panel.tabs.status'),
    ];

    $planText = match ($plan['state']) {
        'none' => __('production-priority::filament/work-panel.tasks.plan.none'),
        'pending' => __('production-priority::filament/work-panel.tasks.plan.pending', ['name' => $plan['name'], 'count' => $plan['count']]),
        default => filled($plan['applied_by'])
            ? __('production-priority::filament/work-panel.tasks.plan.applied', ['user' => $plan['applied_by'], 'date' => $plan['applied_at'], 'count' => $plan['count']])
            : __('production-priority::filament/work-panel.tasks.plan.applied-unknown', ['date' => $plan['applied_at'], 'count' => $plan['count']]),
    };

    $materialText = $material['count'] === 0
        ? __('production-priority::filament/work-panel.tasks.material.empty')
        : trim(__('production-priority::filament/work-panel.tasks.material.description').' '.($material['largest']
            ? __('production-priority::filament/work-panel.tasks.material.largest', $material['largest'])
            : ''));
@endphp

<x-filament-panels::page>
    <div class="wp-root" wire:poll.{{ $pollInterval }}.visible>
        <section class="wp-tasks" aria-labelledby="wp-tasks-heading">
            <h2 id="wp-tasks-heading" class="wp-sr-only">{{ __('production-priority::filament/work-panel.tasks.heading') }}</h2>

            <x-production-priority::work-panel.task-card
                tone="critical"
                icon="heroicon-o-exclamation-triangle"
                :title="__('production-priority::filament/work-panel.tasks.late.title')"
                :count="$late['count']"
                :text="$late['count'] > 0
                    ? __('production-priority::filament/work-panel.tasks.late.description')
                    : __('production-priority::filament/work-panel.tasks.late.empty')"
                :chips="$late['chips']"
            >
                @if ($late['count'] > 0)
                    <x-filament::button tag="a" :href="$late['url']" size="sm" color="gray" outlined>
                        {{ __('production-priority::filament/work-panel.tasks.late.button') }}
                    </x-filament::button>
                @endif
            </x-production-priority::work-panel.task-card>

            <x-production-priority::work-panel.task-card
                tone="plan"
                icon="heroicon-o-flag"
                :title="__('production-priority::filament/work-panel.tasks.plan.title')"
                :count="$plan['state'] === 'none' ? null : $plan['count']"
                :text="$planText"
                :chips="$plan['chips']"
            >
                @if ($plan['state'] === 'none')
                    @can('create', \Weba\ProductionPriority\Models\Evaluation::class)
                        <x-filament::button size="sm" wire:click="mountAction('runEvaluation')">
                            {{ __('production-priority::filament/work-panel.tasks.plan.run') }}
                        </x-filament::button>
                    @endcan
                @elseif ($plan['state'] === 'pending')
                    {{ $this->applyPriorityAction }}
                @else
                    {{ $this->revertPriorityAction }}
                @endif
            </x-production-priority::work-panel.task-card>

            <x-production-priority::work-panel.task-card
                tone="warning"
                icon="heroicon-o-cube"
                :title="__('production-priority::filament/work-panel.tasks.material.title')"
                :count="$material['count']"
                :text="$materialText"
                :chips="$material['chips']"
            >
                @if ($material['count'] > 0 && $material['url'])
                    <x-filament::button tag="a" :href="$material['url']" size="sm" color="gray" outlined>
                        {{ __('production-priority::filament/work-panel.tasks.material.button') }}
                    </x-filament::button>
                @endif
            </x-production-priority::work-panel.task-card>
        </section>

        <section class="wp-stats" aria-labelledby="wp-stats-heading">
            <h2 id="wp-stats-heading" class="wp-sr-only">{{ __('production-priority::filament/work-panel.stats.heading') }}</h2>

            @foreach ($tiles as $tile)
                <x-production-priority::work-panel.stat-tile
                    :label="$tile['label']"
                    :value="$tile['value']"
                    :unit="$tile['unit']"
                    :help="$tile['help']"
                    :help-label="__('production-priority::filament/work-panel.stats.help-button', ['label' => $tile['label']])"
                    wire:key="wp-tile-{{ $tile['key'] }}"
                />
            @endforeach
        </section>

        <section class="wp-panel">
            {{-- Tab pattern: the arrow keys move between tabs (the active one is the only one in the tab order). --}}
            <div
                x-data
                x-on:keydown.arrow-right.prevent="$el.querySelector('[role=tab][aria-selected=true]')?.nextElementSibling?.focus()"
                x-on:keydown.arrow-left.prevent="$el.querySelector('[role=tab][aria-selected=true]')?.previousElementSibling?.focus()"
                x-on:keydown.home.prevent="$el.querySelector('[role=tab]')?.focus()"
                x-on:keydown.end.prevent="[...$el.querySelectorAll('[role=tab]')].at(-1)?.focus()"
                x-on:focusin="if ($event.target.matches('[role=tab][aria-selected=false]:focus-visible')) { $event.target.click() }"
            >
                <x-filament::tabs :label="__('production-priority::filament/work-panel.navigation.title')" class="wp-tabs" role="tablist">
                    @foreach ($tabLabels as $tab => $label)
                        <x-filament::tabs.item
                            :active="$currentTab === $tab"
                            :badge="$tabCounts[$tab]"
                            wire:click="setActiveTab('{{ $tab }}')"
                            wire:key="wp-tab-{{ $tab }}"
                            role="tab"
                            id="wp-tab-{{ $tab }}"
                            aria-selected="{{ $currentTab === $tab ? 'true' : 'false' }}"
                            aria-controls="wp-tabpanel"
                            tabindex="{{ $currentTab === $tab ? '0' : '-1' }}"
                        >
                            {{ $label }}
                        </x-filament::tabs.item>
                    @endforeach
                </x-filament::tabs>
            </div>

            <div class="wp-panel-body" id="wp-tabpanel" role="tabpanel" aria-labelledby="wp-tab-{{ $currentTab }}" tabindex="0">
                @if ($currentTab === WorkPanel::TAB_PRIORITY)
                    <div class="wp-toolbar">
                        <div class="wp-seg" role="group" aria-label="{{ __('production-priority::filament/work-panel.priority.filter.label') }}">
                            @foreach ($rowFilters as $filter)
                                <button
                                    type="button"
                                    wire:click="setRowFilter('{{ $filter }}')"
                                    wire:key="wp-filter-{{ $filter }}"
                                    aria-pressed="{{ $currentFilter === $filter ? 'true' : 'false' }}"
                                >
                                    {{ __('production-priority::filament/work-panel.priority.filter.'.$filter) }}
                                </button>
                            @endforeach
                        </div>

                        <p class="wp-hint">{{ __('production-priority::filament/work-panel.priority.score-help') }}</p>
                    </div>

                    <div class="wp-table">
                        {{ $this->table }}
                    </div>
                @elseif ($currentTab === WorkPanel::TAB_WORK_CENTERS)
                    @if (count($workCenters))
                        <div class="wp-split">
                            <div>
                                <p class="wp-caption">{{ __('production-priority::filament/work-panel.work-centers.caption') }}</p>

                                <ul class="wp-bars">
                                    @foreach ($workCenters as $center)
                                        <li class="wp-bar-row">
                                            <span class="wp-bar-label">{{ $center['name'] }}</span>
                                            <span class="wp-bar-track"><i style="width: {{ $center['percent'] }}%"></i></span>
                                            <span class="wp-bar-value">{{ __('production-priority::filament/work-panel.work-centers.hours', ['hours' => $center['hours']]) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <table class="wp-plain-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('production-priority::filament/work-panel.work-centers.work-center') }}</th>
                                        <th scope="col">{{ __('production-priority::filament/work-panel.work-centers.waiting') }}</th>
                                        <th scope="col">{{ __('production-priority::filament/work-panel.work-centers.running') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workCenters as $center)
                                        <tr>
                                            <th scope="row">{{ $center['name'] }}</th>
                                            <td>{{ __('production-priority::filament/work-panel.work-centers.orders', ['count' => $center['waiting']]) }}</td>
                                            <td>{{ $center['running'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="wp-empty">{{ __('production-priority::filament/work-panel.work-centers.empty') }}</p>
                    @endif
                @else
                    @if ($tabCounts[WorkPanel::TAB_STATUS] > 0)
                        <p class="wp-caption">
                            {{ __('production-priority::filament/work-panel.status.caption', ['count' => $tabCounts[WorkPanel::TAB_STATUS]]) }}
                        </p>

                        <div class="wp-stack">
                            @foreach ($statuses as $status)
                                @if ($status['count'] > 0)
                                    <span
                                        class="wp-stack-segment"
                                        style="width: {{ $status['percent'] }}%; background: var(--wp-state-{{ $status['key'] }})"
                                        title="{{ $status['label'] }}: {{ $status['count'] }}"
                                    ></span>
                                @endif
                            @endforeach
                        </div>

                        <ul class="wp-legend">
                            @foreach ($statuses as $status)
                                <li>
                                    <i class="wp-swatch" style="background: var(--wp-state-{{ $status['key'] }})" aria-hidden="true"></i>
                                    <span>{{ $status['label'] }}</span>
                                    <b>{{ $status['count'] }}</b>
                                    <span class="wp-muted">{{ Number::format($status['percent'], maxPrecision: 0) }}%</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="wp-empty">{{ __('production-priority::filament/work-panel.status.empty') }}</p>
                    @endif
                @endif
            </div>

            <div class="wp-foot">
                <span>{{ $footer['text'] }}</span>
                <a href="{{ $footer['url'] }}" class="wp-link">{{ __('production-priority::filament/work-panel.footer.open') }}</a>
            </div>
        </section>
    </div>
</x-filament-panels::page>
