
<tooltip-trigger
    x-data="tooltip($el, {{ $title }})"
    x-on:mouseenter="onMouseenter"
    x-on:mouseleave="onMouseleave"
    class="leading-none "
>
    {{ $slot }}
</tooltip-trigger>
