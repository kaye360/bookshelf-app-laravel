
<x-layout.modal x-show="showModal" >

    <h3 class="font-semibold" x-text="book.title"></h3>

    <span x-show="!hasTags">
        This book has no tags. Add some below!
    </span>

    <div :id="'tagList-' + book.id" class="flex gap-x-4 gap-y-2 flex-wrap w-full">
    </div>

    <x-form.button
        variant="ghost"
        class="w-fit px-0"
        x-on:click="
            showEdit = !showEdit
            setTimeout( () => $refs.tagTextarea.focus(), 300 )
        "
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
        x-ref="tagTextarea"
    ></textarea>

    <x-form.button
        x-show="showEdit && status !== 'success'"
        x-on:click="
            status = 'loading'
            const res = await $store.booksApi.update(book.id, { tags : tagList })
            if( res.ok ) {
                status = 'success'
                setTimeout( () => status = 'initial', 5000)
            }
            book.tags = tagList
        "
    >
        <x-slot:icon>
            <x-i icon="tag" size="md" x-show="status === 'initial'" />
            <x-i icon="loader-circle" size="md" x-show="status === 'loading'" class="animate-spin" />

        </x-slot:icon>

        <span x-show="status === 'initial'">Update tags</span>
        <span x-show="status === 'loading'">Updating</span>
    </x-form.button>

    <x-form.button variant="ghost" x-show="status === 'success'" disabled>
        <x-slot:icon>
            <x-i icon="circle-check-big" size="md" />
        </x-slot:icon>
        Tags updated.
    </x-form.button>

</x-layout.modal>
