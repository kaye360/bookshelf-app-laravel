<header class="flex items-center gap-6 justify-between sticky top-0 z-50 p-4 mb-6 bg-background/95 border-b border-primary-light">

    <x-layout.logo />

    @auth
        <nav-auth class="fixed bottom-2 md:bottom-0 left-1/2 md:left-auto -translate-x-1/2 md:translate-x-0 md:relative z-50 bg-background/85 backdrop-blur md:backdrop-blur-none rounded p-2 ml-auto shadow-sm shadow-primary-light md:shadow-none">
            <x-layout.nav-link-list class="justify-center gap-6">
                <x-layout.nav-link href="/books">
                    <x-i icon="rows-4" size="sm" class="sm:hidden" />
                    <span class="{{ Request::is('books') ? 'underline underline-offset-2' : '' }}">
                        Bookshelf
                    </span>
                </x-layout.nav-link>
                <x-layout.nav-link href="/community">
                    <x-i icon="users" size="sm" class="sm:hidden" />
                    <span class="{{ Request::is('community') ? 'underline underline-offset-2' : '' }}">
                        Community
                    </span>
                </x-layout.nav-link>
                <x-layout.nav-link href="/search">
                    <x-i icon="search" size="sm" class="sm:hidden" />
                    <span class="{{ Request::is('search') ? 'underline underline-offset-2' : '' }}">
                        Search
                    </span>
                </x-layout.nav-link>
            </x-layout.nav-link-list>
        </nav-auth>
    @endauth

    <x-layout.nav-link-list class="justify-end">
        @guest
            <x-layout.nav-link href="/community">
                <x-i icon="users" size="sm" class="sm:hidden" />
                <span class="text-xs md:text-base">
                    Community
                </span>
            </x-layout.nav-link>
            <x-layout.nav-link href="/login">
                <x-i icon="log-in" size="sm" class="sm:hidden" />
                <span class="text-xs md:text-base">
                    Login
                </span>
            </x-layout.nav-link>
            <x-layout.nav-link href="/register">
                <x-i icon="user-plus" size="sm" class="sm:hidden" />
                <span class="text-xs md:text-base">
                    Register
                </span>
            </x-layout.nav-link>
        @endguest

        @auth
            <a href="/user" class="flex items-center gap-1 border-0 group">
                <span class="text-sm group group-hover:text-accent font-theme">
                    {{ Auth::user()->username }}
                </span>
                <span class="rounded-full bg-primary-light border border-primary-mid aspect-square p-2 group group-hover:bg-accent/70 group-hover:border-background">
                    <x-i icon="user" size="sm" class="group group-hover:text-background" />
                </span>
            </a>
        @endauth

    </x-layout.nav-link-list>

</header>
