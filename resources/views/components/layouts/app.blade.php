<!DOCTYPE html>
<html lang="en" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>Bookshelf</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf">
        @stack('scripts')
        <script src="{{ asset('/js/layout/tooltip.js') }}"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.5/dist/cdn.min.js"></script>
    </head>
    <body class="bg-background text-text font-base">

        <div id="top" class="w-full max-w-[1600px] mx-auto">

            <x-layout.header />

            <main class="px-4 min-h-[80vh]">
                {{ $slot }}
            </main>

            <x-layout.footer />

        </div>

        <x-layout.tooltip />

    </body>
</html>
