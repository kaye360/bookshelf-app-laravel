
@push('scripts')
    <script src="{{ asset('/js/book/api.js') }}"></script>
@endpush

<x-layouts.app title="{{ $book->title }}">

    <section class="grid grid-cols-[3fr_2fr] gap-8 items-start">

        <book-content-wrapper class="h-full relative">
            <book-content-sticky class="grid gap-6 sticky top-24">

                <x-h1 class="border-b-2 border-accent/20">
                    {{ $book->title }}
                </x-h1>

                <book-users
                    x-data="{
                        hasBook : {{ $book->hasBook ? 'true' : 'false' }},
                        showModal : false
                    }"
                    class="flex justify-between items-center"
                >
                    <book-readers class="flex items-center gap-1">
                        @foreach ( $book->readers as $reader )
                            <a
                                href="/user/{{ $reader->username }}"
                                class="w-8 h-8 grid place-items-center font-semibold aspect-square text-sm uppercase rounded-full bg-primary-light border border-primary-mid/50 hover:bg-accent shadow-md shadow-primary-mid/60"
                            >
                                {{ $reader->initial }}
                            </a>
                        @endforeach
                        <span class="italic">
                            {{ $book->readerCount }} {{ $book->readerCount === 1 ? 'user has' : 'users have' }} this book.
                        </span>
                    </book-readers>

                    <div>
                        <x-search.add-book-button-with-modal :$book />
                    </div>
                </book-users>

                @isset( $book->publishDate )
                    <p class="text-sm italic">
                        First published on {{ print_r($book->publishDate) }}
                    </p>
                @endisset

                @isset( $book->description )
                    <p>
                        {{ $book->description }}
                    </p>
                @endisset

                @isset( $book->authors )
                    <div>
                        <h2 class="font-semibold mb-2">Authors</h2>
                        @foreach ( $book->authors as $author )
                            <div class="flex items-center gap-2 mb-2">
                                @if ( isset($author->photo) )
                                    <img
                                        src="{{ $author->photo }}"
                                        class="w-20 h-20 rounded-full object-cover"
                                    />
                                @else
                                    <span class="w-20 h-20 rounded-full bg-primary-light/50 grid place-items-center text-white">
                                        <x-i icon="user-round" size="lg" />
                                    </span>
                                @endif
                                <a href="/aurhor/{{ $author->key }}" class="font-semibold">
                                    {{ $author->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endisset

                @isset( $book->tags )
                    <tags-list-wrapper>
                        <h2 class="font-semibold mb-2">Tags</h2>
                        <tag-list class="flex items-center gap-x-3 gap-y-3 flex-wrap text-sm">
                            @foreach ( $book->tags  as $tag )
                                <a
                                    href="/search-result?query={{ $tag }}"
                                    class="bg-primary-light/30 px-2 py-1 rounded-md border-0"
                                >
                                    #{{ $tag}}
                                </a>
                            @endforeach
                        </tag-list>
                    </tags-list-wrapper>
                @endisset

            </book-content-sticky>
        </book-content-wrapper>

        <book-covers class="grid gap-2">
            @isset( $book->covers)
                @foreach ( $book->covers as $cover )
                    <img
                        src="{{ $cover }}"
                        class="w-full aspect-[1/1.6] object-cover rounded transition-all duration-500"
                    />
                @endforeach
            @endisset
        </book-covers>
    </section>

</x-layouts.app>
