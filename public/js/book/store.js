document.addEventListener('alpine:init', () => {
    Alpine.store('books', {
        init() {
            this.getAll()
        },

        books : [],

        async getAll() {
            const token = document.querySelector('#csrf').content
            const response = await fetch(`/api/books`, {
                method : 'GET',
                headers : {
                    'Accept' : 'application/json',
                    'Content-Type' : 'application/json;charset=UTF-8',
                    'X-CSRF-TOKEN' : token
                }
            })
            const json = await response.json()
            this.books = json
        }
    })
})
