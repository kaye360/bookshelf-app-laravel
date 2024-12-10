
document.addEventListener('alpine:init', () => {
    Alpine.data('addBookHandler', (bookKey) => ({

        status : 'initial',

        async onSubmit() {
            this.status = 'loading'

            const response = await Alpine.store('booksApi').create(
                formDataFromId(bookKey).asJson()
            )

            if( response.id ) {
                this.status = 'success'
                this.$data.hasBook = true
            } else {
                this.status = 'error'
            }
        },
    }))
})
