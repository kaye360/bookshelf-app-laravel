<!DOCTYPE html>
<html lang="en" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>HootReads</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.5/dist/cdn.min.js"></script>
    </head>
    <body class="bg-background text-text font-base">

        <section class="bg-[#182022]">
            <hero-section class="h-[70vh] relative w-full max-w-[1200px] mx-auto ">

                <img src="{{ asset('/img/hero-3.webp') }}" class="w-auto h-full object-contain mx-auto" />

                <logo-top class="absolute left-12 right-12 top-6 flex justify-between">
                    <div class="mix-blend-plus-lighter">
                        <x-layout.logo />
                    </div>
                    <a href="/community" class=" text-gray-300">
                        Community
                    </a>
                </logo-top>

                <hero-content class="absolute left-12 top-1/2 -translate-y-1/2 max-w-md font-theme  text-white flex flex-col gap-6" >

                    <hero-heading class="text-5xl font-normal leading-[3rem] tracking-wide select-none">
                        Track your book collection with <span class="text-accent">Hoot</span>Reads
                    </hero-heading>

                    <hero-subheading class="text-xl tracking-wider select-none">
                        <span class="text-accent">Hoo</span> knew keeping track of your personal library was this easy?
                    </hero-subheading>

                    <x-form.button
                        x-data
                        x-on:click="location.href = '/register'"
                        class="font-base"
                    >
                        <x-slot:icon>
                            <x-i icon="square-arrow-up-right" size="md" />
                        </x-slot:icon>
                        Get started
                    </x-form.button>

                    <x-form.button
                        variant="ghost"
                        class="!text-primary-light border border-primary-light font-base"
                        x-data
                        x-on:click="location.href = '/login'"
                    >
                        <x-slot:icon>
                            <x-i icon="log-in" size="md" />
                        </x-slot:icon>
                        Log in
                    </x-form.button>

                </hero-content>
            </hero-section>
        </section>

    </body>
</html>
>
