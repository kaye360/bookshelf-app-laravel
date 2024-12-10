<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ old($name) }}"
    class="border border-primary-mid bg-background-accent rounded p-2 text-sm w-full {{ $class }}"
    {{ $attributes }}
/>
