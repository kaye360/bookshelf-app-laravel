
document.addEventListener('alpine:init', () => {
    Alpine.data('deleteBook', () => ({

        showModal : false,
        status : 'initial',

        async deleteBook(id) {
            const token = document.querySelector('#csrf').content
            const response = await fetch(`/api/books/${id}`, {
                method : 'DELETE',
                headers : {
                    'Accept' : 'application/json',
                    'Content-Type' : 'application/json;charset=UTF-8',
                    'X-CSRF-TOKEN' : token
                }
            })
            const json = await response.json()
            return !!json
        },

        async deleteBookHandler(id) {
            this.status = 'deleting'
            const response = await this.deleteBook(id)
            if( response ) {
                this.status = 'success'
                setTimeout( () => Alpine.store('books').getAll(), 1000 )
            } else {
                this.status = 'error'
            }
        }
    }))
})
