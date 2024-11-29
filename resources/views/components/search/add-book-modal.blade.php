@php
    // @todo move js into separate folder, add try/catch
    $book_key = str_replace('/works/', '', $book['key']);
    $book_authors = $book['author_name'] ?? [];
    $book_tags = $bookService->formatExternalBookTags( $book['subject'] ?? []);
@endphp

<div
    x-cloak
    x-show="isModalOpen"
    x-data="{
        isAdding : false,
        isAdded : false,
        isError : false,
        async addBook() {
            this.isAdding = true
            const formData = new FormData({{ $book_key }})
            const entries = formData.entries()
            const body = JSON.stringify( Object.fromEntries( entries ) )
            const token = document.querySelector('#csrf').content
            const response = await fetch('/api/books', {
                method : 'POST',
                body,
                headers : {
                    'Accept' : 'application/json',
                    'Content-Type' : 'application/json;charset=UTF-8',
                    'X-CSRF-TOKEN' : token
                }
            })
            if( response.ok ) {
                this.isAdded = true
            } else {
                this.isAdding = false
                this.isError = true
            }
        }
    }"
    x-transition
    class="fixed inset-0 z-50 bg-primary-light/90 grid place-items-center"
>
    <form
        method="POST"
        action="/api/books"
        id="{{ $book_key }}"
        class="relative grid gap-2 bg-background p-6 min-w-[300px] max-w-[90vw] md:max-w-lg rounded-md"
        x-on:click.outside="isModalOpen = false"
        x-on:submit.prevent="() => {
            addBook()
            hasBook = true
        }"
    >

        <input type="hidden" name="key" value="{{ $book['key'] }}" />
        <input type="hidden" name="title" value="{{ $book['title'] }}" />
        <input type="hidden" name="authors" value="{{ json_encode($book_authors)  }}" />

        @isset($book['number_of_pages_median'])
            <input type="hidden" name="page_count" value="{{ $book['number_of_pages_median'] }}" />
        @endisset

        @isset($book['cover_edition_key'])
            <input
                type="hidden"
                name="cover_url"
                value="https://covers.openlibrary.org/b/olid/{{ $book['cover_edition_key'] }}.jpg"
            />
        @endisset

        <h2>
            Adding book <br />
            <span class="font-semibold text-xl">
                {{ $book['title'] }}
            </span>
        </h2>

        <label class="flex items-center gap-1">
            <x-form.checkbox name="is_read" />
            I have read this book
        </label>

        <label class="flex items-center gap-1">
            <x-form.checkbox name="is_owned" />
            I own this book
        </label>

        <div>
            Suggested tags: <br />
            @if( count($book_tags) > 0 )
                <div class="flex items-center flex-wrap gap-3 mt-2 text-sm">
                    @foreach ($book_tags as $tag)
                        <div
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
                        </div>
                    @endforeach
                </div>
            @else
                No suggested tags
            @endisset
        </div>

        <x-form.button x-show="!isAdded">
            <x-form.button-icon >
                <x-i icon="loader-circle" size="md" class=" animate-spin" x-show="isAdding" />
                <x-i icon="square-plus" size="md" x-show="!isAdding"/>
            </x-form.button-icon>
            <span x-show="isAdding">
                Adding Book...
            </span>
            <span x-show="!isAdding">
                Add Book
            </span>
        </x-form.button>

        <span
            class="relative w-fit mx-auto text-md font-semibold flex items-center gap-1 py-3 px-6"
            x-show="isAdded"
        >
            <x-i icon="circle-check" size="md" />
            Book added successfully!
        </span>

        <span class="flex items-center justify-center gap-1" x-show="isAdded">
            <a href="/books">View your bookshelf</a>
        </span>

        <span x-show="isError">
            Something went wrong. Please try again later.
        </span>

        <button
            type="button"
            x-on:click="isModalOpen = false"
            class="absolute top-2 right-2 hover:text-accent"
        >
            <x-i icon="circle-x" size="md" />
        </button>

    </form>

</div>
