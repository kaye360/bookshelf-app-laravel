document.addEventListener('alpine:init', () => {
    Alpine.store('communityPosts', {

        init() {
            this.nextPage()
        },

        posts : [],
        currentPage: 0,
        isAtEnd : false,

        async nextPage() {
            const response = await fetch(`/api/community-posts/${this.currentPage}`)
            const json = await response.json()
            console.log(json)

            if( !json ) {
                this.isAtEnd = true
                return
            }

            this.posts = [...this.posts, ...json]
            this.currentPage++
        },

    })
})
