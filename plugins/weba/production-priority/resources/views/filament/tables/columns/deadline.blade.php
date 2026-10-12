@php
    $cell = $getState();
@endphp

<div class="px-3 py-4">
    @if ($cell)
        <span class="wp-pill wp-pill--{{ $cell['tone'] }}">
            @if ($cell['icon'])
                <x-filament::icon :icon="$cell['icon']" class="wp-pill-icon" />
            @endif
            {{ $cell['text'] }}
        </span>
    @else
        <span class="wp-muted">—</span>
    @endif
</div>
