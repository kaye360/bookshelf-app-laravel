
document.addEventListener('alpine:init', () => {
    Alpine.store('tooltip', {
        title : '',
        show : false,
        xPos : 0,
        yPos : 0,
        pointerOffset : 0
    })
})

document.addEventListener('alpine:init', () => {
    Alpine.data('tooltip', (el, title) => ({

        getTooltipOffset() {
            const tooltip = document.querySelector('tool-tip')
            const tooltipRect = tooltip.getBoundingClientRect()
            return Math.round( tooltipRect.width / 2 )
        },

        getxPos(tooltipRect, offset) {
            const xPos = tooltipRect.left + tooltipRect.width / 2 - offset
            return Math.round( xPos < 5 ? 10 : xPos )
        },

        getyPos(tooltipRect) {
            return Math.round( tooltipRect.top - 40 + window.scrollY )
        },

        getPointerOffset(tooltip, xPos) {
            const childRect = tooltip.firstElementChild.getBoundingClientRect()
            const childCenter = Math.round( childRect.left + childRect.width / 2 )
            return Math.round( childCenter - xPos )
        },

        onMouseenter() {
            const tooltipRect = el.getBoundingClientRect()

            Alpine.store('tooltip').title = title
            Alpine.store('tooltip').show = true

            setTimeout( () => {
                const offset = this.getTooltipOffset()
                const xPos = this.getxPos(tooltipRect, offset)
                const yPos = this.getyPos(tooltipRect)
                const pointerOffset = this.getPointerOffset(el, xPos)

                Alpine.store('tooltip').xPos = xPos
                Alpine.store('tooltip').yPos = yPos
                Alpine.store('tooltip').pointerOffset = pointerOffset
            }, 30 )
        },

        onMouseleave() {
            Alpine.store('tooltip').show = false
        }

    }))
})
