<div class="flex flex-col gap-2" {{ $attributes }}>

    <x-book.cover src="book.cover_url" title="book.title" size="lg" />

    <x-book.actions>
        <x-book.action-is-read />
        <x-book.action-is-owned />
        <x-book.action-is-favourite />
        <x-book.action-more>
            <x-book.action-book-info />
            <x-book.action-book-tags />
            <x-book.action-book-delete />
        </x-book.action-more>
    </x-book.actions>

</div>
