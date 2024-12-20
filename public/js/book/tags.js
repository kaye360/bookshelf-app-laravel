
document.addEventListener('alpine:init', () => {
    Alpine.data('updateTags', (book) => ({

        init() {
            this.$watch( () => [this.tags, this.showModal, this.showEdit] , () => {

                this.tagList = getTagList( this.tags )
                this.checkIfHasTags()
                updateUiTags(this.tagList, book.id)

                // Close without saving changes and reset modal
                if( !this.showModal ) {
                    this.tags = book.tags.join(' ').trim() || ''
                    this.checkIfHasTags()
                    this.showEdit = false
                }
            })
        },

        tags : book && book.tags.join(' ').trim() || '',
        tagList : [],
        status : 'initial',

        showModal : false,
        showEdit : false,
        hasTags : false,

        checkIfHasTags()  {
            this.hasTags = !( !this.tags || this.tags.trim() ===  '')
        }
    }))
})

function getTagList( tags ) {

    if( !tags ) return []

    const tagsFormatted = tags
        .replaceAll('<', '')
        .replaceAll('>', '')
        .toLowerCase()

    const tagsArray = tagsFormatted.split(' ')
    const tagsArrayUnique = Array.from( new Set(tagsArray) ).filter(t => t !== '')

    return tagsArrayUnique.length > 0 ? tagsArrayUnique : []
}

function updateUiTags(tagArray, id) {

    if( !Array.isArray(tagArray) ) return

    const tagListEl = document.querySelector('#tagList-' + id)
    if( !tagListEl ) return

    tagListEl.textContent = ''

    const tagListHtml = tagArray.map( tag => `
        <a href="/books/tag/${tag}">#${tag}</a>
    `)

    tagListEl.insertAdjacentHTML('beforeEnd', tagListHtml.join(' ') )
}
