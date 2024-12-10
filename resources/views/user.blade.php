
<x-layouts.app title="{{ Auth::user()->username }}">

    <div class="grid gap-6">

        <section class="flex justify-between items-end border-b-2 border-accent/20">
            <x-h1>
                <x-i icon="at-sign" size="lg" />
                {{ Auth::user()->username }}
            </x-h1>
            <a href="/settings" class="flex items-center gap-1 border-none pb-1 hover:underline">
                <x-i icon="settings" size="md" />
                Settings
            </a>
        </section>

        <section class="grid gap-1">
            <span class="flex items-center gap-1 font-medium">
                <x-i icon="book-copy" size="md" />
                Total books
            </span>
            <span class="flex items-center gap-1 font-medium">
                <x-i icon="locate-fixed" size="md" />
                Location
            </span>
            <span class="flex items-center gap-1 font-medium">
                <x-i icon="calendar-plus" size="md" />
                Joined {{  date('M d, Y', strtotime( Auth::user()->created_at )) }}
            </span>
        </section>

        <section class="py-24 bg-primary-light/20">
            User books
        </section>

        <section class="py-24 bg-primary-light/20">
            User Topics
        </section>

        <section>
            <form method="POST" action="/logout">
                @csrf
                <x-form.button>
                    <x-i icon="log-out" size="md" />
                    Logout
                </x-form.button>
            </form>
        </section>

    </div>


</x-layouts.app>
