<x-layout.modal x-show="showModal">

    <h3 class="font-semibold" x-text="book.title"></h3>

    <span x-show="!hasTags">
        This book has no tags. Add some below!
    </span>

    <div :id="'tagList-' + book.id" class="flex gap-x-4 gap-y-2 flex-wrap w-full">
    </div>

    <x-form.button
        variant="ghost"
        class="w-fit px-0"
        x-on:click="showEdit = !showEdit"
    >
        <x-i icon="tag" size="sm" />
        Edit Tags
    </x-form.button>

    <span
        x-show="showEdit"
        class="flex gap-2 p-2 bg-background-accent rounded mb-2"
        x-transition
    >
        <x-i icon="circle-alert" size="md" />
        Note: Separate each tag with a space. No hashtag is required.
    </span>

    <textarea
        x-transition
        x-show="showEdit"
        rows="3"
        class="p-2"
        x-model="tags"
    ></textarea>

    <x-form.button x-show="showEdit">
        Update tags
    </x-form.button>

</x-layout.modal>
