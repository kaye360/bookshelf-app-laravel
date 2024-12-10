
function formDataFromId(id) {
    const form = document.getElementById(id)
    const formData = new FormData(form)
    const entries = formData.entries()
    const body =  Object.fromEntries( entries )

    return {
        asObject : () => body,
        asJson : () => JSON.stringify(body)
    }
}
