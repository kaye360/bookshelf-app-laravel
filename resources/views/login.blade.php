<x-layouts.app>

    <login-columns class="grid grid-cols-2 w-fit mx-auto  gap-24 mt-12 items-center">

        <login-form class="grid gap-4">

            <x-h1>
                Sign in to your account
            </x-h1>

            <form
                method="POST"
                action="/login"
                class="grid gap-5"
                x-data="{ status : 'initial' }"
                x-on:submit="status = 'loading'"
            >
                @csrf

                <label>
                    <span class="font-semibold">Username</span><br />
                    <x-form.input type="text" name="username" />
                </label>

                <label>
                    <span class="font-semibold">Password</span><br />
                    <x-form.input type="password" name="password" />
                </label>

                @if( $errors->any() )
                    <span class="text-rose-500">
                        Incorrect username or password. Please try again.
                    </span>
                @enderror

                <x-form.button x-bind:disabled="status === 'loading'">
                    <x-slot:icon>
                        <x-i icon="log-in" size="md" x-show="status === 'initial'" />
                        <x-i icon="loader-circle" size="md" class="animate-spin" x-show="status === 'loading'" x-cloak />
                    </x-slot:icon>
                    <span x-show="status === 'initial'">Login</span>
                    <span x-show="status === 'loading'" x-cloak>Logging in...</span>
                </x-form.button>

                <span>
                    Don't have an account? <a href="/register">Register</a>
                </span>

            </form>
        </login-form>

        <img src="{{ asset('img/books-table-1.webp') }}" />

    </login-columns>
</x-layouts.app>
