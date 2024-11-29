@push('scripts')
    <script src="{{ asset('/js/book/store.js') }}"></script>
@endpush
<x-layouts.app>

    <div
        x-data
        class="grid justify-center grid-cols-[repeat(auto-fit,150px)] gap-8 items-start"
    >

        <template x-for="book in $store.books.books" :key="book.id">
            <div class="flex flex-col gap-2">

                <x-book.cover src="book.cover_url" title="book.title" />

                <x-book.action-button-list book="book" />

            </div>
        </template>

    </div>
</x-layouts.app>
