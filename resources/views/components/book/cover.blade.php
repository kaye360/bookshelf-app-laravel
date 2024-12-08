@once
    @push('scripts')
        <script src="{{ asset('/js/utils/bookAnimation.js') }}"></script>
    @endpush
@endonce

<div
    x-data="{
        hasCover : {{ $src }} || false,
        src : {{ $src }} || null,
        title : {{ $title }} || 'N/A',
        size : '{{ $size }}',
    }"
    :class="{
        'relative' : true,
        'w-[50px] h-[83x]' : size === 'sm',
        'w-[100px] h-[166px]' : size === 'md',
        'w-[150px] h-[250px]' : size === 'lg',
    }"
>

    {{-- Cover --}}
    <img
        x-show="hasCover"
        x-bind:src="src"
        x-on:load="bookOnload($el)"
        :width="{
            50 : size === 'sm',
            100 : size === 'md',
            150 : size === 'lg',
        }"
        :height="{
            83 : size === 'sm',
            166 : size === 'md',
            250 : size === 'lg',
        }"
        :class="{
            'object-cover rounded shadow-lg shadow-primary-dark/30 opacity-0 scale-90 transition-all duration-500 relative z-10' : true,
            'w-[50px] h-[83px]' : size === 'sm',
            'w-[100px] h-[166px]' : size === 'md',
            'w-[150px] h-[250px]' : size === 'lg',
        }"
        loading="lazy"
    />

    {{-- Loading Spinner --}}
    <div
        x-show="hasCover"
        class="absolute inset-0 -z-10 font-semibold text-primary-dark/30 bg-primary-light/30 rounded"
    >
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <x-i
                icon="loader-circle"
                size="md"
                class="animate-spin"
            />
        </div>
    </div>

    {{-- Cover Not Available --}}
    <div
        x-show="!hasCover"
        x-data="{ show : false }"
        x-effect="setTimeout( () => { show = true }, 100 )"
    >
        <div
            x-show="show"
            :class="{
                'p-2 bg-primary-light/50 grid place-items-center text-center text-lg font-semibold text-primary-dark/50 rounded select-none shadow-lg shadow-primary-dark/30' : true,
                'w-[50px] h-[83px]' : size === 'sm',
                'w-[100px] h-[166px]' : size === 'md',
                'w-[150px] h-[250px]' : size === 'lg',
            }"
            x-text="size === 'sm' ? title.slice(0,1) : title"
            x-transition:enter="transition duration-500"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-1 scale-100"
        >
        </div>
    </div>

</div>
