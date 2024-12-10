{{--
    @prop $book -> External API book
    @x-data showModal : boolean
    @x-data hasBook : boolean
--}}

<button
    x-data
    class="flex items-center gap-1 px-3  py-1 text-primary-dark/80 font-semibold bg-primary-light/30"
    x-on:click.stop="showModal = true"
    x-show="!hasBook"
>
    <x-i icon="square-plus" size="sm" />
    Add Book
</button>

<user-has-book-message
    class="flex items-center gap-1 text-sm italic"
    x-show="hasBook"
>
    <x-i icon="circle-check-big" size="sm" />
    You have this book in your bookshelf.
</user-has-book-message>

@if( !$book['hasBook'] )
    <x-search.add-book-modal :$book />
@endif
