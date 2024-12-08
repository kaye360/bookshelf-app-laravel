@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('deleteBook', () => ({
                    showModal : false,
                    status : 'initial',

                    async deleteBookHandler(id) {
                        this.status = 'deleting'
                        const response = await Alpine.store('booksApi').delete(id)
                        if( response ) {
                            this.status = 'success'
                            setTimeout( () => Alpine.store('booksApi').getAll(), 1000 )
                        } else {
                            this.status = 'error'
                        }
                    }
                }))
            })
        </script>
    @endpush
@endonce

<delete-book x-data="deleteBook">
    <button
        x-on:click.stop="showModal = true"
        class="flex items-center gap-2 w-full px-4 hover:bg-primary-light"
    >
        <x-i icon="circle-x" size="sm" />
        Delete
    </button>

    <x-book.delete-book-modal />

</delete-book>
