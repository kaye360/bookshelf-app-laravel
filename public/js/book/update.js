async function updateBook(id, update) {
    const token = document.querySelector('#csrf').content
    await fetch(`/api/books/${id}`, {
        method : 'PUT',
        body : JSON.stringify(update),
        headers : {
            'Accept' : 'application/json',
            'Content-Type' : 'application/json;charset=UTF-8',
            'X-CSRF-TOKEN' : token
        }
    })
}
