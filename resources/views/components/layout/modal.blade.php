<template x-teleport="body">
    <div
        {{ $attributes }}
        x-transition
        class="fixed inset-0 z-50 bg-primary-light/90 grid place-items-center"
    >
        <div
            x-on:click.outside="showModal = false"
            class="relative grid gap-2 bg-background p-6 min-w-[300px] max-w-[90vw] md:w-[600px] rounded-md"
        >
            {{ $slot }}
            <button
                type="button"
                class="absolute top-2 right-2 hover:text-accent"
                x-on:click="showModal = false"
            >
                <x-i icon="circle-x" size="md" />
            </button>
        </div>
    </div>
</template>