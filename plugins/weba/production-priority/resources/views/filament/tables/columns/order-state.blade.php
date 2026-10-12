@php
    $state = $getState();
@endphp

<div class="px-3 py-4">
    @if ($state)
        <span class="wp-state">
            <i class="wp-state-dot" style="background: var(--wp-state-{{ $state['key'] }})" aria-hidden="true"></i>
            {{ $state['label'] }}
        </span>
    @else
        <span class="wp-muted">—</span>
    @endif
</div>
