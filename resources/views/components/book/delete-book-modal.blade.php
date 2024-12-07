
<x-layout.modal>
    <delete-book-modal class="grid gap-4 py-4">

        <span class="flex gap-3 text-lg">
            <x-i icon="circle-x" size="lg" class="stroke-accent" />
            <p>
                Are you sure you want to delete
                <span x-text="book.title" class="font-semibold"></span>
                from your bookshelf?
            </p>
        </span>

        <x-form.button
            x-on:click="deleteBookHandler(book.id)"
            x-show="status === 'initial'"
        >
            <x-slot:icon>
                <x-i icon="bookmark-x" size="md" />
            </x-slot:icon>
            Delete Book
        </x-form.button>

        <x-form.button
            variant="ghost"
            x-show="status === 'deleting'"
            disabled
        >
            <x-slot:icon>
                <x-i icon="loader-circle" size="md" class="animate-spin" />
            </x-slot:icon>
            Deleting...
        </x-form.button>

        <x-form.button
            variant="ghost"
            x-show="status === 'success'"
            disabled
        >
            <x-slot:icon>
                <x-i icon="circle-check-big" size="md" />
            </x-slot:icon>
            This book has been deleted.
        </x-form.button>

        <x-form.button
            variant="ghost"
            x-show="status === 'error'"
            disabled
        >
            <x-slot:icon>
                <x-i icon="circle-alert" size="md" />
            </x-slot:icon>
            Something went wrong, please try again later.
        </x-form.button>

    </delete-book-modal>
</x-layout.modal>
