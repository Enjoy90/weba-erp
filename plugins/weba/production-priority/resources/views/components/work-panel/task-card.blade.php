@props([
    'tone',
    'icon',
    'title',
    'count' => null,
    'text',
    'chips' => ['items' => [], 'more' => 0],
])

<article class="wp-task wp-task--{{ $tone }}">
    <div class="wp-task-head">
        <span class="wp-task-icon" aria-hidden="true">
            <x-filament::icon :icon="$icon" />
        </span>

        <h3 class="wp-task-title">{{ $title }}</h3>

        @if ($count !== null)
            <span class="wp-task-count">{{ $count }}</span>
        @endif
    </div>

    <p class="wp-task-text">{{ $text }}</p>

    @if (count($chips['items']))
        <ul class="wp-chips">
            @foreach ($chips['items'] as $chip)
                <li>
                    <a class="wp-chip" href="{{ $chip['url'] }}">{{ $chip['label'] }}</a>
                </li>
            @endforeach

            @if ($chips['more'] > 0)
                <li class="wp-chips-more">
                    {{ __('production-priority::filament/work-panel.tasks.more', ['count' => $chips['more']]) }}
                </li>
            @endif
        </ul>
    @endif

    @if ($slot->isNotEmpty())
        <div class="wp-task-action">
            {{ $slot }}
        </div>
    @endif
</article>
