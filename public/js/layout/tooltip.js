
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
            return tooltipRect.width / 2
        },

        onMouseenter() {
            const tooltipRect = el.getBoundingClientRect()
            const childRect = el.firstElementChild.getBoundingClientRect()
            const childCenter = childRect.left + childRect.width / 2

            Alpine.store('tooltip').title = title
            Alpine.store('tooltip').show = true
            Alpine.store('tooltip').childxPos = tooltipRect.left

            setTimeout( () => {
                const offset = this.getTooltipOffset()

                let xPos = tooltipRect.left + tooltipRect.width / 2 - offset
                    xPos = xPos < 5 ? 10 : xPos

                const pointerOffset = childCenter - xPos

                Alpine.store('tooltip').xPos = Math.round(xPos)
                Alpine.store('tooltip').yPos = Math.round( tooltipRect.top - 40 + window.scrollY )
                Alpine.store('tooltip').pointerOffset = Math.round( pointerOffset )
            }, 30 )
        },

        onMouseleave() {
            Alpine.store('tooltip').show = false
        }

    }))
})
