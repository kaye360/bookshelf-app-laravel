<!DOCTYPE html>
<html lang="en" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>Bookshelf</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ledger&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        <script src="//unpkg.com/alpinejs" defer></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf">
        @stack('scripts')
    </head>
    <body class="bg-background text-text font-base">
        <div
            id="top"
            class="w-full max-w-[1400px] mx-auto"
        >
            <x-layout.header />
            <main class="px-4 min-h-[80vh]">
                {{ $slot }}
            </main>
            <x-layout.footer />
        </div>

    </body>
</html>
