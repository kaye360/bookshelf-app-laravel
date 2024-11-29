@php
    $title = $book['title'];
    $src = isset($book['cover_edition_key'])
        ? "https://covers.openlibrary.org/b/olid/" . $book['cover_edition_key'] . ".jpg"
        : null
@endphp

<div
    class="flex items-start gap-4"
    x-data="{ 'isModalOpen' : false, hasBook : {{ $hasBook ? 'true' : 'false' }} }"
>

    {{-- Covers --}}
    <div
        class="min-w-[100px]"
        x-data="{ title : `{{ $title }}` || 'N/A', src : `{{ $src }}` || null }"
    >
        <x-book.cover src="src" title="title" />
    </div>

    {{-- Content --}}
    <div class="flex flex-col gap-3 items-start">
        <h3 class="font-semibold text-2xl">
            {{ $book['title'] }}
        </h3>

        @isset($book['author_name'])
            <div class="flex items-center gap-2 flex-wrap text-md font-semibold">
                @for ( $i = 0; $i < count( $book['author_name'] ); $i++ )
                    {{ $book['author_name'][$i] }}
                @endfor
            </div>
        @endisset

        <span
            class="flex items-center gap-1 text-sm italic"
            x-show="hasBook"
        >
            <x-i icon="circle-check-big" size="sm" />
            You have this book in your bookshelf.
        </span>

        <button
            class="flex items-center gap-1 px-3  py-1 text-primary-dark/80 font-semibold bg-primary-light/30"
            x-on:click="isModalOpen = true"
            x-show="!hasBook"
        >
            <x-i icon="square-plus" size="sm" />
            Add Book
        </button>

        {{ $slot }}

    </div>

</div>
