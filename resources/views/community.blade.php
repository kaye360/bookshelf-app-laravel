@php
    function communityPostTypeTitle( $post ) {
        $isSingle = count($post) === 1;
        $titles = [
            'CREATE_BOOK' => $isSingle ? 'added a book' : "added " . count($post) . ' books',
            'FAVOURITE_BOOK' => $isSingle ? 'favourited a book' : "favourited " . count($post) . ' books',
            'READ_BOOK' => $isSingle ? 'read a book' : "read " . count($post) . ' books',
            'JOIN' => 'joined HootReads!',
        ];
        return $titles;
    }
@endphp

<x-layouts.app>

    <div class="grid gap-8">

        @foreach ($community_posts as $communityPost )

            <div>

                <h2 class="font-semibold text-lg mb-2 flex items-center gap-2">
                    @if ( $communityPost[0]['type'] === 'CREATE_BOOK' )
                        <x-i icon="book-plus" size="sm" class="stroke-1" />
                    @endif
                    @if ( $communityPost[0]['type'] === 'FAVOURITE_BOOK' )
                        <x-i icon="heart" size="sm" class="stroke-1" />
                    @endif
                    @if ( $communityPost[0]['type'] === 'READ_BOOK' )
                        <x-i icon="circle-check-big" size="sm" class="stroke-1" />
                    @endif
                    @if ( $communityPost[0]['type'] === 'JOIN' )
                        <x-i icon="user" size="sm" class="stroke-1" />
                    @endif
                    <a href="/user/{{ $communityPost[0]['username'] }}">
                        {{ $communityPost[0]['username'] }}
                    </a>
                    {{ communityPostTypeTitle($communityPost)[ $communityPost[0]['type'] ] }}
                </h2>

                <div class="flex items-center flex-wrap gap-4 mb-2">
                    @foreach ( array_slice($communityPost, 0, 10) as $book )

                        @if ( $book['type'] !== 'JOIN' )
                            <x-tooltip title="{{ $book['title'] }}">
                                <a href="/books/{{ $book['key'] }}" class="relative rounded-lg">
                                    <x-book.cover
                                        src="'{{ $book['cover_url'] }}'"
                                        title="'{{ $book['title'] }}'"
                                        size="sm"
                                    />
                                </a>
                            </x-tooltip>
                        @endif

                        @if ( $book['type'] === 'JOIN' )
                            <div class="flex items-center gap-2">
                                <div class="bg-primary-light/30 p-2 rounded-lg">
                                    <x-i icon="user-round-plus" size="xl" class="stroke-1 text-primary-mid" />
                                </div>
                                <span>
                                    View <a href="/user/{{ $book['username'] }}">{{ $book['username'] }}'s</a> profile
                                </span>
                            </div>
                        @endif

                    @endforeach
                    @if( count($communityPost) > 10 )
                        <span class="text-lg font-medium select-none">
                            + {{ count($communityPost) - 10 }} more
                        </span>
                    @endif
                </div>

            </div>

        @endforeach
    </div>

</x-layouts.app>
