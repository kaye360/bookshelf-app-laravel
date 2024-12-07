@push('scripts')
    <script src="{{ asset('/js/book/tags.js') }}"></script>
@endpush

<book-tags
    x-data="updateTags(book)"
    x-init="$nextTick( () => updateUiTags(tags, book.id) )"
>
    <button
        x-on:click.stop="showModal = true"
        class="flex items-center gap-2 w-full px-4 hover:bg-primary-light"
    >
        <x-i icon="tag" size="sm" />
        Tags
    </button>

    <x-book.tags-modal />
</book-tags>
