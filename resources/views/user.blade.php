
<x-layouts.app title="{{ $user->username }}">

    <div class="grid gap-6">

        <section class="flex justify-between items-end border-b-2 border-accent/20">
            <x-h1>
                <x-i icon="at-sign" size="lg" />
                {{ $user->username }}
            </x-h1>
            <a href="/settings" class="flex items-center gap-1 border-none pb-1 hover:underline">
                <x-i icon="settings" size="md" />
                Settings
            </a>
        </section>

        <section class="grid gap-1">
            <span class="flex items-center gap-1 font-medium">
                <x-i icon="book-copy" size="md" />
                Total books: {{ $books->count() }}
            </span>
            <span class="flex items-center gap-1 font-medium">
                <x-i icon="locate-fixed" size="md" />
                Location
            </span>
            <span class="flex items-center gap-1 font-medium">
                <x-i icon="calendar-plus" size="md" />
                Joined {{  date('M d, Y', strtotime( $user->created_at )) }}
            </span>
        </section>

        <section class="py-6">

            <h2 class="font-semibold text-theme mb-4">
                Some of {{ $user->username }}'s books
            </h2>

            <div class="flex flex-wrap gap-2">
                @foreach ( $books->slice(0, 20) as $book)
                    <x-tooltip title="'{{ $book->title }}'">
                        <a href="/books/{{ $book->key }}" class="border-0">
                            <x-book.cover
                                title="'{{ $book->title }}'"
                                src="'{{ $book->cover_url }}'"
                                size="sm"
                            />
                        </a>
                    </x-tooltip>
                @endforeach
            </div>
        </section>

        <section class="py-6">

            <h2 class="font-semibold text-theme mb-4">
                {{ $user->username }} likes to read about
            </h2>

            <div class="flex flex-wrap gap-x-4 gap-y-2">

                @foreach ( $tags->slice(0, 50) as $tag )
                    <a href="/search-result?query={{ $tag->tag }}">
                        #{{ $tag->tag }}
                    </a>
                @endforeach
            </div>

        </section>

        <section class="py-6">

            <h2 class="font-semibold text-theme mb-4">
                {{ $user->username }}'s favourite authors
            </h2>

            <div class="flex flex-wrap gap-x-4 gap-y-2">

                @foreach ( $authors as $author )
                    <a href="/author/{{ $author->key }}">
                        {{ $author->name }}
                    </a>
                @endforeach
            </div>

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
