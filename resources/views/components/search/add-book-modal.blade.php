
@once
    @push('scripts')
        <script src="{{ asset('/js/utils/form.js') }}"></script>
        <script src="{{ asset('/js/book/handlers.js') }}"></script>
    @endpush
@endonce

<x-layout.modal>

    <add-book-modal x-data="addBookHandler('{{ $book->key }}')">
        <form
            method="POST"
            id="{{ $book->key }}"
            class="relative grid gap-2"
            x-on:submit.prevent="onSubmit()"
        >

            <input type="hidden" name="key" value="{{ $book->key }}" />
            <input type="hidden" name="title" value="{{ $book->title }}" />
            <input type="hidden" name="authors" value="{{ json_encode($book->authors)  }}" />

            @isset($book->pageCount)
                <input type="hidden" name="page_count" value="{{ $book->pageCount }}" />
            @endisset

            @isset($book->covers[0])
                <input
                    type="hidden"
                    name="cover_url"
                    value="{{ $book->covers[0] }}"
                />
            @endisset

            <h2 class="font-semibold">
                {{ $book->title }}
            </h2>

            <label class="flex items-center gap-1">
                <x-form.checkbox name="is_read" />
                I have read this book
            </label>

            <label class="flex items-center gap-1">
                <x-form.checkbox name="is_owned" />
                I own this book
            </label>

            <suggested-tags>

                <h2 class="font-semibold">
                    Suggested tags:
                </h2>

                @if( count($book->randomTags) > 0 )

                    <suggested-tags-wrapper class="flex items-center flex-wrap gap-3 mt-2 text-sm">

                        @foreach ($book->randomTags as $tag)

                            <suggested-tag
                                x-ref="tag{{ $loop->index }}"
                                class="flex items-center gap-1 bg-primary-light/30 rounded-lg px-2 py-1"
                            >
                                <span>
                                    #{{ $tag }}
                                    <input type="hidden" name="tag{{ $loop->index }}" value="{{ $tag }}" />
                                </span>
                                <button
                                    type="button"
                                    x-on:click="$refs.tag{{ $loop->index }}.remove()"
                                >
                                    <x-i icon="x-circle" size="sm" />
                                </button>
                            </suggested-tag>

                        @endforeach

                    </suggested-tags-wrapper>
                @else
                    No suggested tags
                @endisset
            </suggested-tags>

            <x-form.button x-show="status === 'loading' || status === 'initial'">
                <x-slot:icon >
                    <x-i icon="square-plus" size="md" x-show="status === 'initial'" />
                    <x-i icon="loader-circle" size="md" class=" animate-spin" x-show="status === 'loading'" />
                </x-slot:icon>
                <span x-show="status === 'initial'">
                    Add Book
                </span>
                <span x-show="status === 'loading'">
                    Adding Book...
                </span>
            </x-form.button>

            <span
                class="relative w-fit mx-auto text-md font-semibold flex items-center gap-1 py-3 px-6"
                x-show="status === 'success'"
            >
                <x-i icon="circle-check" size="md" />
                Book added successfully!
            </span>

            <span class="flex items-center justify-center gap-1" x-show="status === 'success'">
                <a href="/books">View your bookshelf</a>
            </span>

            <span x-show="status === 'error'">
                Something went wrong. Please try again later.
            </span>

        </form>

    </add-book-modal>
</x-layout.modal>
