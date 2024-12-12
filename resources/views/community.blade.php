
@push('scripts')
    <script src="{{ asset('/js/communityPost/communityPost.js') }}"></script>
@endpush

<x-layouts.app title="Community">

    <community-post-list x-data class="grid gap-12 min-h-screen">

        <template x-for="post in $store.communityPosts.posts">
            <community-post>

                <community-post-title class="font-semibold text-lg mb-2 flex items-center gap-2">
                    <template x-if="post.type === 'CREATE_BOOK'">
                        <x-i icon="book-plus" size="sm" />
                    </template>
                    <template x-if="post.type === 'READ_BOOK'">
                        <x-i icon="circle-check-big" size="sm" />
                    </template>
                    <template x-if="post.type === 'FAVOURITE_BOOK'">
                        <x-i icon="heart" size="sm" />
                    </template>
                    <template x-if="post.type === 'JOIN'">
                        <x-i icon="user" size="sm" />
                    </template>
                    <a :href="`/user/${post.username}`" x-text="post.username + ' ' + post.title"></a>
                </community-post-title>

                <community-post-content class="flex items-center flex-wrap gap-4 mb-2">

                    <template x-for="book in post.books.slice(0, 10)">

                        <div>
                            <template x-if="post.type !== 'JOIN'">
                                <x-tooltip title="book.title" >
                                    <a :href="`/books/${book.key}`" class="relative rounded-lg">
                                        <x-book.cover
                                            src="book.cover_url"
                                            title="book.title"
                                            size="sm"
                                        />
                                    </a>
                                </x-tooltip>
                            </template>

                            <template x-if="post.type === 'JOIN'">
                                <user-join class="flex items-center gap-2">
                                    <user-join-icon class="bg-primary-light/30 p-2 rounded-lg">
                                        <x-i icon="user-round-plus" size="xl" class="stroke-1 text-primary-mid" />
                                    </user-join-icon>
                                    <user-profile>
                                        View
                                        <a :href="`/user/${book.username}`" x-text="book.username"></a>'s profile
                                    </user-profile>
                                </user-join>
                            </template>
                        </div>

                    </template>

                    <template x-if="post.bookCount > 10">
                        <more-books
                            class="text-lg font-medium select-none"
                            x-text="`+ ${post.bookCount - 10} more`"
                        >
                        </more-books>
                    </template>

                </community-post-content>

            </community-post>
        </template>

    </community-post-list>

    <more-posts-trigger
        x-data
        x-cloak
        x-intersect="$store.communityPosts.nextPage()"
        class="flex items-center gap-2 text-lg font-semibold py-12"
        x-show="!$store.communityPosts.isAtEnd"
    >
        <x-i icon="loader-circle" size="lg" class="animate-spin" />
        Loading more posts
    </more-posts-trigger>

</x-layouts.app>
