
<x-tooltip title="Owned">
    <x-book.action-button x-on:click=" () => {
        $store.booksApi.update(book.id, { is_owned : !book.is_owned })
        book.is_owned = !book.is_owned
    }">
        <x-i icon="bookmark" size="sm" class=" w-5 h-5 stroke-1" x-show="!book.is_owned" />
        <x-i icon="bookmark" size="sm" class=" w-5 h-5 stroke-1 stroke-primary-dark/50 fill-primary-dark/50" x-show="book.is_owned" />
    </x-book.action-button>
</x-tooltip>
