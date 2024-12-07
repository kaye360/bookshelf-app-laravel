
<search-bar x-data>

    <search-field class="relative">
        <x-form.input
            type="text"
            name="search"
            x-on:input.debounce.500ms="$store.viewOptions.setParam('search', $el.value)"
            x-bind:value="$store.viewOptions.search"
            placeholder="Search your library"
        />

        <x-i
            icon="search"
            size="md"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-mid"
        />

    </search-field>

    <button
        x-on:click="$store.viewOptions.setParam('search', '')"
        x-show="$store.viewOptions.search"
        x-transition
        class="flex items-center gap-1 text-sm mt-2 text-primary-mid hover:text-accent"
    >
        Clear search
        <x-i icon="circle-x" size="sm" />
    </button>

</search-bar>


<filter-select class="flex flex-col gap-2 items-start " x-data>

    <x-book.view-option-heading>
        <x-i icon="list-filter" size="sm" />
        Filter
    </x-book.view-option-heading>

    <button
        x-on:click="$store.viewOptions.setParam('filter', 'all')"
        :class="{'opacity-40' : $store.viewOptions.filter !== 'all', 'hover:underline' : true }"
    >All</button>

    <button
        x-on:click="$store.viewOptions.setParam('filter', 'favourite')"
        :class="{'opacity-40' : $store.viewOptions.filter !== 'favourite', 'hover:underline' : true }"
    >Favourites</button>

    <div>
        <button
            x-on:click="$store.viewOptions.setParam('filter', 'read')"
            :class="{'opacity-40' : $store.viewOptions.filter !== 'read', 'hover:underline mr-2' : true }"
        >Read</button>
        <button
            x-on:click="$store.viewOptions.setParam('filter', 'notread')"
            :class="{'opacity-40' : $store.viewOptions.filter !== 'notread', 'hover:underline' : true }"
        >Not read</button>
    </div>

    <div>
        <button
            x-on:click="$store.viewOptions.setParam('filter', 'owned')"
            :class="{'opacity-40' : $store.viewOptions.filter !== 'owned', 'hover:underline mr-2' : true }"
        >Owned</button>
        <button
            x-on:click="$store.viewOptions.setParam('filter', 'notowned')"
            :class="{'opacity-40' : $store.viewOptions.filter !== 'notowned', 'hover:underline' : true }"
        >Not owned</button>
    </div>


</filter-select>

<sort-select class="flex flex-col gap-2 items-start" x-data>

    <x-book.view-option-heading>
        <x-i icon="arrow-up-down" size="sm" />
        Sort
    </x-book.view-option-heading>

    <button
        x-on:click="$store.viewOptions.setParam('sort', 'newest')"
        :class="{'opacity-40' : $store.viewOptions.sort !== 'newest', 'hover:underline mr-2' : true }"
    >Newest</button>

    <button
        x-on:click="$store.viewOptions.setParam('sort', 'oldest')"
        :class="{'opacity-40' : $store.viewOptions.sort !== 'oldest', 'hover:underline mr-2' : true }"
    >Oldest</button>

    <button
        x-on:click="$store.viewOptions.setParam('sort', 'title')"
        :class="{'opacity-40' : $store.viewOptions.sort !== 'title', 'hover:underline mr-2' : true }"
    >Title</button>

    <button
        x-on:click="$store.viewOptions.setParam('sort', 'author')"
        :class="{'opacity-40' : $store.viewOptions.sort !== 'author', 'hover:underline mr-2' : true }"
    >Author</button>

</sort-select>

<view-select class="flex flex-col gap-2 items-start" x-data>

    <x-book.view-option-heading>
        <x-i icon="layout-list" size="sm" />
        View
    </x-book.view-option-heading>

    <button
        x-on:click="$store.viewOptions.setParam('view', 'grid')"
        :class="{'opacity-40' : $store.viewOptions.view !== 'grid', 'hover:underline mr-2' : true }"
    >Grid</button>

    <button
        x-on:click="$store.viewOptions.setParam('view', 'list')"
        :class="{'opacity-40' : $store.viewOptions.view !== 'list', 'hover:underline mr-2' : true }"
    >List</button>

    <button
        x-on:click="$store.viewOptions.setParam('view', 'card')"
        :class="{'opacity-40' : $store.viewOptions.view !== 'card', 'hover:underline mr-2' : true }"
    >Card</button>

</view-select>

<tag-select class="flex flex-col gap-2 items-start" x-data>

    <x-book.view-option-heading>
        <x-i icon="tags" size="sm" />
        Popular tags
    </x-book.view-option-heading>

    <button
        x-on:click="$store.viewOptions.setParam('tag', '')"
        :class="{'opacity-40' : $store.viewOptions.tag !== '', 'hover:underline mr-2' : true }"
    >Clear Tags</button>

    <template x-for="tag in tags" :key="tag.tag">
        <button
            x-on:click="$store.viewOptions.setParam('tag', tag.tag)"
            :class="{'opacity-40 text-left' : $store.viewOptions.tag !== tag.tag, 'hover:underline mr-2' : true }"
        >
            <span x-text="`${tag.tag} - (${tag.count})`"></span>
        </button>
    </template>

</tag-select>

<x-book.view-option-heading>
    <x-i icon="settings" size="sm" />
    Settings
</x-book.view-option-heading>
