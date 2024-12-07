
document.addEventListener('alpine:init', () => {
    Alpine.store('viewOptions', {

        init() {
            /**
             * Get and set initial values from URL params if they exist
            */
            const params = new URLSearchParams(window.location.search)
            for( const [param, value] of params ) {

                if( !isValidParamKey(param) ) {
                    params.delete(param)
                    window.history.replaceState({}, '', "?" + params.toString());
                    continue
                }

                if( isValidParamValue(param, value) ) {
                    this[param] = value
                }
            }
        },

        filter : defaultParamValues.filter,
        sort : defaultParamValues.sort,
        view : defaultParamValues.view,
        tag : defaultParamValues.tag,
        search : defaultParamValues.search,

        setParam(param, value) {

            /**
             * @todo add scroll to top once param is set
             */

            if( !isValidParamKey(param) ) {
                console.warn('Invalid param: ' + param)
                return
            }

            if( !isValidParamValue(param, value) ) {
                value = defaultParamValues[param]
            }

            const params = new URLSearchParams(window.location.search)
            params.set(param, value)
            history.pushState({}, '', '?' + params.toString());
            this[param] = value
            window.scrollTo({
                top : 0,
                behavior : 'smooth'
            })
        }
    })
})

/**
 *
 * Default Values for each URL param
 *
 */
const defaultParamValues = {
    filter : 'all',
    sort : 'newest',
    view : 'card',
    tag : '',
    search : ''
}

/**
 *
 * Valid URL param values
 *
 */
const validate = {
    param : ['filter', 'sort', 'view', 'tag', 'search'],
    filter : ['all', 'read', 'notread', 'owned', 'notowned', 'favourite'],
    sort : ['newest', 'oldest', 'title', 'author'],
    view : ['grid', 'list', 'card'],
}

/**
 *
 * @function isValidParamKey()
 * @returns boolean
 *
 */
function isValidParamKey(param) {
    return validate.param.includes(param)
}

/**
 *
 * @function isValidParamKey()
 * @returns boolean
 * Note: tag and search params don't have valid values
 * so they are automatically validated
 *
 */
function isValidParamValue(param, value) {
    return param === 'tag' ||
        param === 'search' ||
        validate[param].includes(value)
}
