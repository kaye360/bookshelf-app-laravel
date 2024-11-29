@php
    use App\Services\BookService;
@endphp

<x-layouts.app>

    <div x-data="{ isSearchLoaderShown : false }">

        <x-h1>
            Find your books
        </x-h1>

        <form
            method="get"
            action="/search-result"
            x-on:submit="isSearchLoaderShown = true"
            class="flex gap-2 items-stretch "
        >

            <x-form.input type="text" name="query" placeholder="Enter a book title, author, subject or ISBN" />

            <x-form.button>
                <x-i icon="search" size="md" />
                <span class="hidden sm:block">
                    Search
                </span>
            </x-form.button>

        </form>

        @if ( $errors )
            <p class="my-4">
                Something went wrong with your search. Please try again later.
            </p>
        @endif

        <x-search.loader />

        @isset( $result )

            <h2 class="font-semibold text-3xl w-full my-8">
                <a href="/search" class=" float-right flex items-center gap-1 mt-2 border-transparent hover:border-accent min-w-max text-sm">
                    <x-i icon="circle-x" size="sm" />
                    Clear results
                </a>
                Search results for: <br />
                <span class="text-accent">
                    {{ $query }}
                </span>
            </h2>

            <div class="grid gap-8">
                @foreach ( $result as $book )
                    <x-search.book :$book hasBook="{{ $book['hasBook'] }}">
                        @if( !$book['hasBook'] )
                            <x-search.add-book-modal :$book />
                        @endif
                    </x-search.book>
                @endforeach
            </div>

        @endisset

    </div>

</x-layouts.app>
