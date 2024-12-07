document.addEventListener('alpine:init', () => {
    Alpine.store('booksApi', {

        init() {
            this.getAll()
        },

        books : [],

        async getAll() {
            const response = await fetch(`/api/books`, {
                method : 'GET',
                headers : getHeaders()
            })
            const json = await response.json()
            this.books = json
        },

        async create(body) {
            const response = await fetch('/api/books', {
                method : 'POST',
                body,
                headers : getHeaders()
            })
            const json = response.json()
            return json
        },

        async update(id, update) {
            const response = await fetch(`/api/books/${id}`, {
                method : 'PUT',
                body : JSON.stringify(update),
                headers : getHeaders()
            })
            return response
        },

        async delete(id) {
            const response = await fetch(`/api/books/${id}`, {
                method : 'DELETE',
                headers : getHeaders()
            })
            const json = await response.json()
            return !!json
        },

    })
})

function getHeaders() {
    return {
        'Accept' : 'application/json',
        'Content-Type' : 'application/json;charset=UTF-8',
        'X-CSRF-TOKEN' : document.querySelector('#csrf').content
    }
}
