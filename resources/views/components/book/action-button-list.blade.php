
@push('scripts')
    <script src="{{ asset('/js/book/update.js') }}" defer></script>
    <script src="{{ asset('/js/book/delete.js') }}"></script>
    <script src="{{ asset('/js/book/tags.js') }}"></script>
@endpush


<div
    class="relative flex items-center gap-2 w-fit mx-auto"
    x-data="{ showMoreActions : false, book : {{ $book }} }"
>

    {{-- Is Read --}}
    <x-book.action-button x-on:click=" () => {
        updateBook(book.id, { is_read : !book.is_read })
        book.is_read = !book.is_read
    }">
        <x-i icon="circle-check-big" size="md" class=" stroke-1 w-5 h-5" x-show="book.is_read" />
        <x-i icon="circle" size="md" class=" stroke-1 w-5 h-5" x-show="!book.is_read" />
    </x-book.action-button>

    {{-- Is Owned --}}
    <x-book.action-button x-on:click=" () => {
        updateBook(book.id, { is_owned : !book.is_owned })
        book.is_owned = !book.is_owned
    }">
        <x-i icon="bookmark" size="md" class=" w-5 h-5 stroke-1" x-show="!book.is_owned" />
        <x-i icon="bookmark" size="md" class=" w-5 h-5 stroke-1 stroke-primary-dark/50 fill-primary-dark/50" x-show="book.is_owned" />
    </x-book.action-button>

    {{-- Is Favourite --}}
    <x-book.action-button x-on:click=" () => {
        updateBook(book.id, { is_favourite : !book.is_favourite })
        book.is_favourite = !book.is_favourite
    }">
        <x-i icon="heart" size="md" class=" stroke-1" x-show="!book.is_favourite" />
        <x-i icon="heart" size="md" class=" stroke-1 stroke-primary-dark/50 fill-primary-dark/50" x-show="book.is_favourite" />
    </x-book.action-button>

    {{-- More Actions --}}
    <x-book.action-button x-on:click="showMoreActions = !showMoreActions">
        <x-i icon="ellipsis-vertical" size="md" class="stroke-1" />
    </x-book.action-button>

    <div
        class="absolute left-0 right-0 bottom-full z-50 grid gap-2 abg-primary-dark/95 bg-background font-medium py-2 rounded"
        x-show="showMoreActions"
        x-transition:enter.duration.350ms
        x-transition:leave.duration.1000ms
        x-transition.scale.origin.bottom
        x-on:click.outside="showMoreActions = false"
    >

        {{-- Book Info --}}
        <a :href="`/books/${book.key}`" class="flex items-center gap-2 w-full px-2 hover:bg-primary-light border-0">
            <x-i icon="info" size="sm" />
            Info
        </a>

        {{-- Tags --}}
        <div
            x-data="{
                showModal : false,
                showEdit : false,
                tags : JSON.parse(book.tags).join(' ').trim() || '',
                hasTags : false,
                checkIfHasTags()  {
                    this.hasTags = !( !this.tags || this.tags.trim() ===  '')
                }
            }"
            x-effect="
                updateUiTags(tags, book.id)
                checkIfHasTags()
                if( !showModal ) {
                    tags = JSON.parse(book.tags).join(' ').trim() || ''
                    checkIfHasTags()
                    showEdit = false
                }
            "
            x-init=" $nextTick( () => updateUiTags(tags, book.id) )"
        >
            <button
                x-on:click="showModal = true"
                class="flex items-center gap-2 w-full px-2 hover:bg-primary-light"
            >
                <x-i icon="tag" size="sm" />
                Tags
            </button>

            <x-book.tags-modal />
        </div>

        {{-- Delete --}}
        <div x-data="deleteBook">
            <button
                x-on:click="showModal = true"
                class="flex items-center gap-2 w-full px-2 hover:bg-primary-light"
            >
                <x-i icon="circle-x" size="sm" />
                Delete
            </button>

            <x-book.delete-book-modal />

        </div>

    </div>

</div>
