

<search-result-book
    class="flex items-start gap-4"
    x-data="{
        showModal : false,
        hasBook : {{ $book->hasBook ? 'true' : 'false' }},
    }"
>

    <book-cover
        class="min-w-[100px]"
        x-data="{ title : `{{ $book->title }}` || 'N/A', src : `{{ $book->covers[0] ?? null }}` || null }"
    >
        <x-book.cover size="lg" src="src" title="title" />
    </book-cover>

    <book-content class="flex flex-col gap-3 items-start">
        <h3 class="font-semibold text-2xl">
            <a href="/books/{{ $book->key }}">
                {{ $book->title }}
            </a>
        </h3>

        @isset($book->authors)
            <book-authors class="flex items-center gap-2 flex-wrap text-md font-semibold">
                @foreach ( $book->authors as $author )
                    {{ $author->name }}
                @endforeach
            </book-authors>
        @endisset

        <x-search.add-book-button-with-modal :$book />

    </book-content>

</search-result-book>

