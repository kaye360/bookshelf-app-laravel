
<div class="grid grid-cols-[50px_1.5fr_1fr_auto] gap-4 items-center hover:bg-background-accent">

    <x-book.cover src="book.cover_url" title="book.title" size="sm" />

    <span class="font-semibold" x-text="book.title"></span>

    <div class="flex flex-wrap gap-x-2 gap-y-1 text-xs">
        <template x-for="tag in JSON.parse(book.tags)">
            <button
                x-on:click="$store.viewOptions.setParam('tag', tag)"
                x-text="'#' + tag"
                class="text-left hover:underline"
            >
            </button>
        </template>
    </div>

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
