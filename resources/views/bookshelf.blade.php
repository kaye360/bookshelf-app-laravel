@push('scripts')
    <script src="{{ asset('/js/book/api.js') }}"></script>
    <script src="{{ asset('/js/book/viewOptions.js') }}"></script>
    <script src="{{ asset('/js/book/renderBooks.js') }}"></script>
@endpush

<x-layouts.app title="Your bookshelf">

    {{-- Grid Wrapper --}}
    <bookshelf-grid
        x-data="{ isSidebarOpen : true }"
        x-cloak
        :class="{
            'grid items-start transition-all duration-500' : true,
            'grid-cols-[1fr_200px] gap-14 ' : isSidebarOpen,
            'grid-cols-[1fr_36px] gap-2' : !isSidebarOpen,
        }"
    >

        {{-- Bookshelf --}}
        <bookshelf-content x-data="renderBooks">

            {{-- Current search/tag/filter --}}
            <current-filter
                x-show="$store.viewOptions.tag || $store.viewOptions.search || $store.viewOptions.filter !== 'all'"
                class="flex items-end gap-2 col-span-full text-lg mb-4"
                x-data="{
                    filterTitles : {
                        favourite : 'Your favourites',
                        read : 'Books you\'ve read',
                        notread : 'Books you haven\'t read yet',
                        owned : 'Books you own',
                        notowned : 'Books you don\'t own yet'
                    }
                }"
            >
                <current-search-query
                    x-show="$store.viewOptions.search"
                    x-text="'Search for ' + $store.viewOptions.search"
                ></current-search-query>

                <current-tag-filter
                    x-show="!$store.viewOptions.search && $store.viewOptions.tag"
                    x-text="'Showing books tagged as #' + $store.viewOptions.tag"
                ></current-tag-filter>

                <current-filter
                    x-show="!$store.viewOptions.search && ! $store.viewOptions.tag && $store.viewOptions.filter !== 'all'"
                    x-text="'Filter by: ' + filterTitles[$store.viewOptions.filter]"
                ></current-filter>

                <button
                    x-on:click="
                        $store.viewOptions.setParam('search', '')
                        $store.viewOptions.setParam('tag', '')
                        $store.viewOptions.setParam('filter', 'all')
                    "
                    class="text-sm mb-1 flex items-center gap-1 hover:text-accent"
                >
                    <x-i icon="circle-x" size="sm" class="text-primary-mid hover:text-accent" />
                </button>
            </current-filter>

            {{-- Book Loop --}}

            <template x-if="$store.viewOptions.view === 'card'">
                <book-list-card
                    class="grid items-start grid-cols-[repeat(auto-fill,minmax(275px,1fr))] gap-8"
                >
                    <template x-for="book in renderBookShelf" :key="book.id" >
                        <x-book.views.card />
                    </template>
                </book-list-card>
            </template>

            <template x-if="$store.viewOptions.view === 'list'">
                <book-list-item
                    class="grid items-start gap-2"
                >
                    <template x-for="book in renderBookShelf" :key="book.id">
                        <x-book.views.list-item />
                    </template>
                </book-list-item>
            </template>

            <template x-if="$store.viewOptions.view === 'grid'">
                <book-list-grid
                    class="grid items-start grid-cols-[repeat(auto-fit,150px)] justify-start gap-8 content-start"
                >
                    <template x-for="book in renderBookShelf" :key="book.id">
                        <x-book.views.grid />
                    </template>
                </book-list-grid>
            </template>

            {{-- Empty bookshelf --}}
            <template x-if="$store.booksApi.books.length === 0 && $store.booksApi.status === 'loaded'">
                    <div class="flex flex-col items-center gap-3 text-lg mt-6 w-fit mx-auto">
                        <x-i icon="book-marked" size="xl" class="text-primary-light" />
                        <span class="text-xl">
                            Your bookshelf is empty.
                        </span>
                        <span class="text-base">
                            Add some by <a href="/search">searching</a> or browsing the <a href="/community">community</a>!
                        </span>
                    </div>
            </template>

        </bookshelf-content>

        {{-- View Options --}}
        <view-options class="overflow-clip justify-self-end">

            <toggle-view-options class="mb-8">
                <button
                    x-on:click="isSidebarOpen = !isSidebarOpen"
                    class="flex items-center justify-end gap-1 text-sm text-primary-dark hover:bg-primary-light p-2 ml-auto rounded-xl"
                >
                    <span x-show="isSidebarOpen" class="text-sm min-w-max">Hide options</span>
                    <x-i icon="ellipsis-vertical" size="md" class="stroke-2" x-show="!isSidebarOpen" />
                    <x-i icon="circle-x" size="md" class="stroke-1" x-show="isSidebarOpen" />
                </button>
            </toggle-view-options>

            <view-options
                x-data="{ tags : {{ Js::from($tags) }} }"
                :class="{
                    'grid gap-8 transition-all duration-500' : true,
                    'opacity-100' : isSidebarOpen,
                    'opacity-0' : !isSidebarOpen,
                }"
            >
                <x-book.view-options />
            </view-options>

        </view-options>

    </bookshelf-grid>
</x-layouts.app>
