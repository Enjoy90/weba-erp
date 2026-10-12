@php
    $percent = $getState();
@endphp

<div class="px-3 py-4">
    @if ($percent !== null)
        <div class="wp-progress">
            <span
                class="wp-progress-track"
                role="progressbar"
                aria-label="{{ __('production-priority::filament/work-panel.priority.progress-label', ['order' => $getRecord()->order?->name ?? '']) }}"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-valuenow="{{ round($percent) }}"
            >
                <i style="width: {{ min(100, max(0, $percent)) }}%"></i>
            </span>
            <span class="wp-progress-value">{{ \Illuminate\Support\Number::format($percent, maxPrecision: 0) }}%</span>
        </div>
    @else
        <span class="wp-muted">—</span>
    @endif
</div>
