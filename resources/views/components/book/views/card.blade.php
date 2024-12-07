
<div class="grid grid-cols-[auto_1fr] items-start border border-primary-light/40 rounded-xl">

    <x-book.cover src="book.cover_url" title="book.title" size="md" />

    <div class="flex flex-col h-full gap-2 py-2 pl-4 pr-6 ">

        <h3 x-text="book.title" class="text-md font-semibold leading-5"></h3>

        <div class="flex flex-wrap gap-x-2 text-xs">
            <template x-for="tag in JSON.parse(book.tags)">
                <button
                    x-on:click="$store.viewOptions.setParam('tag', tag)"
                    x-text="'#' + tag"
                >
                </button>
            </template>
        </div>

        <div class="mt-auto w-fit">
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

    </div>

</div>
