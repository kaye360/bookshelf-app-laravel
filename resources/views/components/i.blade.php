
<x-dynamic-component
    :component="'lucide-' . $icon"
    {{ $attributes }}
    @class([
        $class,
        'w-4 h-4' => $size === 'sm',
        'w-6 h-6' => $size === 'md',
        'w-8 h-8' => $size === 'lg',
    ])
/>
