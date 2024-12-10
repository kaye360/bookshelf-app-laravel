@php
    $title = $book['title'];
    $book_key = str_replace('/works/', '', $book['key']);
    $src = isset($book['cover_edition_key'])
        ? "https://covers.openlibrary.org/b/olid/" . $book['cover_edition_key'] . ".jpg"
        : null
@endphp

<search-result-book
    class="flex items-start gap-4"
    x-data="{
        showModal : false,
        hasBook : {{ $book['hasBook'] ? 'true' : 'false' }},
    }"
>

    <book-cover
        class="min-w-[100px]"
        x-data="{ title : `{{ $title }}` || 'N/A', src : `{{ $src }}` || null }"
    >
        <x-book.cover size="lg" src="src" title="title" />
    </book-cover>

    <book-content class="flex flex-col gap-3 items-start">
        <h3 class="font-semibold text-2xl">
            <a href="/books/{{ $book_key }}">
                {{ $book['title'] }}
            </a>
        </h3>

        @isset($book['author_name'])
            <book-authors class="flex items-center gap-2 flex-wrap text-md font-semibold">
                @for ( $i = 0; $i < count( $book['author_name'] ); $i++ )
                    {{ $book['author_name'][$i] }}
                @endfor
            </book-authors>
        @endisset

        <x-search.add-book-button-with-modal :$book />

    </book-content>

</search-result-book>

