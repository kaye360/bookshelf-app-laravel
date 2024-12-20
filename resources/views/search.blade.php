@push('scripts')
    <script src="{{ asset('/js/book/api.js') }}"></script>
@endpush

<x-layouts.app title="Search million of books!">

    <search-wrapper x-data="{ isSearchLoaderShown : false }">

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
            <error-message class="block py-12">
                Something went wrong with your search. Please try again later.
            </error-message>
        @endif

        <x-search.loader />

        @isset( $result )

            <h2 class="font-semibold text-3xl w-full my-8">

                <a href="/search" class=" float-right flex items-center gap-1 mt-2 border-transparent hover:border-accent min-w-max text-sm">
                    <x-i icon="circle-x" size="sm" />
                    Clear results
                </a>

                Search results for: <br />

                <search-query class="text-accent">
                    {{ $query }}
                </search-query>
            </h2>

            <search-results class="grid gap-8">
                @foreach ( $result as $book )
                    <x-search.book :$book />
                @endforeach
            </search-results>

        @endisset

    </search-wrapper>

</x-layouts.app>
