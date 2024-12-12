
<x-tooltip title="'More'">
    <x-book.action-button x-on:click="showMoreActions = !showMoreActions">
        <x-i icon="ellipsis-vertical" size="sm" class="stroke-1" />
    </x-book.action-button>
</x-tooltip>

<div
    class="absolute left-0 right-0 bottom-full z-50 grid gap-2 abg-primary-dark/95 bg-background-accent  font-medium py-2 rounded"
    x-show="showMoreActions"
    x-transition:enter.duration.350ms
    x-transition:leave.duration.1000ms
    x-transition.scale.origin.bottom
    x-on:click.outside="showMoreActions = false"
>
    {{ $slot }}
</div>
