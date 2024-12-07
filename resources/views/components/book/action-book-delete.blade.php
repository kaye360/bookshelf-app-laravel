
{{-- Delete --}}
<delete-book x-data="{
    showModal : false,
    status : 'initial',

    async deleteBookHandler(id) {
        this.status = 'deleting'
        const response = await $store.booksApi.delete(id)
        if( response ) {
            this.status = 'success'
            setTimeout( () => $store.booksApi.getAll(), 1000 )
        } else {
            this.status = 'error'
        }
    }
}">
    <button
        x-on:click.stop="showModal = true"
        class="flex items-center gap-2 w-full px-4 hover:bg-primary-light"
    >
        <x-i icon="circle-x" size="sm" />
        Delete
    </button>

    <x-book.delete-book-modal />

</delete-book>
