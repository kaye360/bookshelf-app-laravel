
<x-dynamic-component
    :component="'lucide-' . $icon"
    {{ $attributes }}
    @class([
        $class,
        'w-5 h-5' => $size === 'sm',
        'w-7 h-7' => $size === 'md',
        'w-9 h-9' => $size === 'lg',
        'w-12 h-12' => $size === 'xl',
        'w-16 h-16' => $size === '2xl',
    ])
/>
