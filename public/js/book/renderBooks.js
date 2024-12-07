

document.addEventListener('alpine:init', () => {
    Alpine.data('renderBooks', () => ({

        books : [],

        renderBookShelf() {
            this.books = Alpine.store('booksApi').books
            const filter = Alpine.store('viewOptions').filter
            const sort = Alpine.store('viewOptions').sort
            const tag = Alpine.store('viewOptions').tag || null
            const search = Alpine.store('viewOptions').search || null

            if( search ) {
                this.searchFor(search)
            }

            if( !search && tag ) {
                this.filterByTag(tag)
            }

            if( !search && !tag ) {
                this.filterBy(filter)
            }

            this.sortBy(sort)

            return this.books
        },

        searchFor(search) {
            this.books = this.books.filter( book =>
                book.authors.toLowerCase().includes( search ) ||
                book.title.toLowerCase().includes( search ) ||
                JSON.parse(book.tags).filter( tag => tag.includes( search )).length > 0
            )
        },

        filterByTag(tag) {
            this.books = this.books.filter( book => JSON.parse( book.tags ).includes(tag) )
        },

        filterBy(filter) {
            switch( filter ) {
                case 'read':
                    this.books = this.books.filter( book => book.is_read )
                    break
                case 'notread':
                    this.books = this.books.filter( book => !book.is_read )
                    break
                case 'owned':
                    this.books = this.books.filter( book => book.is_owned )
                    break
                case 'notowned':
                    this.books = this.books.filter( book => !book.is_owned )
                    break
                case 'favourite':
                    this.books = this.books.filter( book => book.is_favourite )
                    break
            }
        },

        sortBy(sort) {
            switch( sort ) {
                case 'newest':
                    this.books = this.books.sort( (a,b) => a.created_at < b.created_at ? 1 : -1 )
                    break
                case 'oldest':
                    this.books = this.books.sort( (a,b) => a.created_at > b.created_at ? 1 : -1 )
                    break
                case 'title':
                    this.books = this.books.sort( (a,b) => a.title !== b.title ? a.title < b.title ? -1 : 1 : 0 )
                    break
                case 'author':
                    this.books = this.books.sort( (a,b) => a.authors !== b.authors ? a.authors < b.authors ? -1 : 1 : 0 )
                    break
            }
        }

    }))
})
