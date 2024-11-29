<x-layouts.app>

    <section class="grid grid-cols-[3fr_2fr] gap-8 items-start">

        <div class="grid gap-6">

            <x-h1 class="border-b-2 border-accent/20">
                {{ $book['title'] }}
            </x-h1>

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
                                <span class="block w-20">NA</span>
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

        </div>

        <div class="flex items-start overflow-scroll">
            @isset( $book['covers'])
                @foreach ( $book['covers'] as $cover )
                    <img
                        src="https://covers.openlibrary.org/b/id/{{ $cover }}-L.jpg"
                        class="w-full aspect-[1/1.6] object-cover rounded transition-all duration-500"
                    />
                @endforeach
            @endisset
        </div>
    </section>

</x-layouts.app>