<button
    type="submit"
    @class([
        'relative flex items-center justify-center gap-2 py-3 px-6 font-semibold rounded hover:scale-[1.03] transition-all duration-75 text-md disabled:hover:scale-100 ',
        'bg-accent text-background' => $variant === 'accent',
        'bg-transparent text-text' => $variant === 'ghost',
        $class
    ])
    {{ $attributes }}
>

    @isset( $icon )
        <span class="w-6 h-6 absolute top-1/2 left-4 -translate-y-1/2">
            {{ $icon }}
        </span>
    @endisset

    {{ $slot }}

</button>
