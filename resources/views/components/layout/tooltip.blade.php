
<tool-tip
    x-data
    x-show="$store.tooltip.show"
    x-cloak
    x-transition.opacity
    x-effect="
        $el.style.left = $store.tooltip.xPos + 'px'
        $el.style.top = $store.tooltip.yPos + 'px'
    "
    class="absolute z-[999] bg-primary-dark text-white font-medium px-3 py-1 rounded-md text-sm"
>

    <span x-text="$store.tooltip.title"></span>

    <tool-tip-point
        class="absolute -z-10 -translate-x-1/2 top-[70%] w-3 h-3 rotate-45 bg-primary-dark"
        :style="{ left : $store.tooltip.pointerOffset + 'px' }"
    >
    </tool-tip-point>

</tool-tip>
