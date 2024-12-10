
@push('scripts')
    <script src="{{ asset('/js/book/api.js') }}"></script>
@endpush

<x-layouts.app title="{{ $book['title'] }}">

    <section class="grid grid-cols-[3fr_2fr] gap-8 items-start">

        <book-content-wrapper class="h-full relative">
            <book-content-sticky class="grid gap-6 sticky top-24">

                <x-h1 class="border-b-2 border-accent/20">
                    {{ $book['title'] }}
                </x-h1>

                <book-users
                    x-data="{
                        hasBook : {{ $book['hasBook'] ? 'true' : 'false' }},
                        showModal : false
                    }"
                    class="flex justify-between items-center"
                >
                    <book-readers class="flex items-center gap-1">
                        @foreach ( $readers as $reader )
                            <a
                                href="/user/{{ $reader->username }}"
                                class="w-8 h-8 grid place-items-center font-semibold aspect-square text-sm uppercase rounded-full bg-primary-light border border-primary-mid/50 hover:bg-accent shadow-md shadow-primary-mid/60"
                            >
                                {{ $reader->initial }}
                            </a>
                        @endforeach
                        <span class="italic">
                            {{ count($readers) }} {{ count($readers) === 1 ? 'user has' : 'users have' }} this book.
                        </span>
                    </book-readers>

                    <div>
                        <x-search.add-book-button-with-modal :$book />
                    </div>
                </book-users>

                @isset( $book['first_publish_date'] )
                    <p class="text-sm italic">
                        First published on {{ print_r($book['first_publish_date']) }}
                    </p>
                @endisset

                @isset( $book['description'] )
                    <p>
                        @if ( is_array($book['description']) )
                            {{ $book['description']['value'] }}
                        @else
                            {{ $book['description'] }}
                        @endif
                    </p>
                @endisset

                @isset( $authors )
                    <div>
                        <h2 class="font-semibold mb-2">Authors</h2>
                        @foreach ( $authors as $author )
                            <div class="flex items-center gap-2 mb-2">
                                @if ( isset($author['photos']) )
                                    <img
                                        src="https://covers.openlibrary.org/a/id/{{ $author['photos'][0] }}-M.jpg"
                                        class="w-20 h-20 rounded-full object-cover"
                                    />
                                @else
                                    <span class="w-20 h-20 rounded-full bg-primary-light/50 grid place-items-center text-white">
                                        <x-i icon="user-round" size="lg" />
                                    </span>
                                @endif
                                <span class="font-semibold">
                                    {{ $author['name'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endisset

                @isset( $book['subjects'] )
                    <div>
                        <h2 class="font-semibold mb-2">Subjects</h2>
                        @foreach ( array_slice($book['subjects'], 0, 10)  as $subject )
                            {{ $subject}},
                        @endforeach
                    </div>
                @endisset

            </book-content-sticky>
        </book-content-wrapper>

        <book-covers class="grid gap-2">
            @isset( $book['covers'])
                @foreach ( $book['covers'] as $cover )
                    <img
                        src="https://covers.openlibrary.org/b/id/{{ $cover }}-L.jpg"
                        class="w-full aspect-[1/1.6] object-cover rounded transition-all duration-500"
                    />
                @endforeach
            @endisset
        </book-covers>
    </section>

</x-layouts.app>
