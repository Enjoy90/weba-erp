@props(['label', 'value', 'unit' => '', 'help', 'helpLabel'])

<div class="wp-stat">
    <div class="wp-stat-label">
        {{ $label }}

        <button
            type="button"
            class="wp-info"
            aria-label="{{ $helpLabel }}"
            x-data
            x-tooltip="{
                content: @js($help),
                theme: $store.theme,
            }"
        >
            ?
        </button>
    </div>

    <div class="wp-stat-value">
        {{ $value }}
        @if (filled($unit))
            <small>{{ $unit }}</small>
        @endif
    </div>

    <span class="wp-sr-only">{{ $help }}</span>
</div>
