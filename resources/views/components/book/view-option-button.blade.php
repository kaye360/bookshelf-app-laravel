<button
    :class="{'opacity-50' : $store.viewOptions.filter !== 'owned', 'hover:underline mr-2' : true }"
    {{ $attributes }}
>

{{ $slot }}

</button>
