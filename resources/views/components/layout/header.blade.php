<header class="flex items-center justify-between sticky top-0 z-50 bg-background px-4 py-6">

    <x-layout.logo />

    @auth
        <div class="fixed bottom-2 md:bottom-auto left-1/2 md:left-auto -translate-x-1/2 md:translate-x-0 md:relative z-50 bg-background/85 backdrop-blur md:backdrop-blur-none rounded p-2 shadow-sm shadow-primary-light md:shadow-none">
            <x-layout.nav-link-list class="justify-center gap-3">
                <x-layout.nav-link href="/dashboard">
                    <x-i icon="layout-dashboard" size="sm" />
                    <span>
                        Dashboard
                    </span>
                </x-layout.nav-link>
                <x-layout.nav-link href="/books">
                    <x-i icon="rows-4" size="sm" />
                    <span>
                        Bookshelf
                    </span>
                </x-layout.nav-link>
                <x-layout.nav-link href="/community">
                    <x-i icon="users" size="sm" />
                    <span>
                        Community
                    </span>
                </x-layout.nav-link>
                <x-layout.nav-link href="/search">
                    <x-i icon="search" size="sm" />
                    <span>
                        Search
                    </span>
                </x-layout.nav-link>
            </x-layout.nav-link-list>
        </div>
    @endauth

    <x-layout.nav-link-list class="justify-end">
        @guest
            <x-layout.nav-link href="/community">
                <x-i icon="users" size="sm" />
                <span class="text-xs md:text-base">
                    Community
                </span>
            </x-layout.nav-link>
            <x-layout.nav-link href="/login">
                <x-i icon="log-in" size="sm" />
                <span class="text-xs md:text-base">
                    Login
                </span>
            </x-layout.nav-link>
            <x-layout.nav-link href="/register">
                <x-i icon="user-plus" size="sm" />
                <span class="text-xs md:text-base">
                    Register
                </span>
            </x-layout.nav-link>
        @endguest
        @auth
            <a href="/user" class="rounded-full bg-background-accent hover:bg-primary-light border border-text/40 aspect-square p-2">
                <x-i icon="user" size="md" />
            </a>
        @endauth
    </x-layout.nav-link-list>

</header>
