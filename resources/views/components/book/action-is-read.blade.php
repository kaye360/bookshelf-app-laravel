
{{-- Is Read --}}
<x-tooltip title="'Read'">
    <x-book.action-button
        x-on:click="
            $store.booksApi.update(book.id, { is_read : !book.is_read })
            book.is_read = !book.is_read
            "
        >
        <x-i icon="circle-check-big" size="sm" class=" stroke-1 w-5 h-5" x-show="book.is_read" />
        <x-i icon="circle" size="sm" class=" stroke-1 w-5 h-5" x-show="!book.is_read" />
    </x-book.action-button>
</x-tooltip>
