
<x-tooltip title="Favourite">
    <x-book.action-button x-on:click=" () => {
        $store.booksApi.update(book.id, { is_favourite : !book.is_favourite })
        book.is_favourite = !book.is_favourite
    }">
        <x-i icon="heart" size="sm" class=" stroke-1" x-show="!book.is_favourite" />
        <x-i icon="heart" size="sm" class=" stroke-1 stroke-primary-dark/50 fill-primary-dark/50" x-show="book.is_favourite" />
    </x-book.action-button>
</x-tooltip>
