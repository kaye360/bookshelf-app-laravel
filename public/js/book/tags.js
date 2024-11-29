
function updateUiTags(tags, id) {
    const tagListEl = document.querySelector('#tagList-' + id)
    if( !tagListEl ) return

    const tagsFormatted = tags
        .replaceAll('<', '')
        .replaceAll('>', '')
        .toLowerCase()

    const tagsArray = tagsFormatted.split(' ')
    const tagsArrayUnique = Array.from( new Set(tagsArray) ).filter(t => t !== '')

    tagListEl.textContent = ''
    if( tagsArrayUnique.length === 0 ) return

    const tagsListHtml = tagsArrayUnique.map( t => `
        <a href="/books/tag/${t}">#${t}</a>
    `).join(' ')

    tagListEl.insertAdjacentHTML('beforeEnd', tagsListHtml)
}
