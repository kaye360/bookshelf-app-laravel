<x-layouts.app>

    <div class="grid grid-cols-2 gap-12 items-center">

        <div class="grid gap-4">

            <x-h1>
                Sign in to your account
            </x-h1>

            <form method="POST" action="/login" class="grid gap-5">
                @csrf

                <label>
                    <span class="font-semibold">Username</span><br />
                    <x-form.input type="text" name="username" />
                </label>

                <label>
                    <span class="font-semibold">Password</span><br />
                    <x-form.input type="text" name="password" />
                </label>

                @if( $errors->any() )
                    <span class="text-rose-500">
                        Incorrect username or password. Please try again.
                    </span>
                @enderror

                {{-- @todo add loading spinners and button disabled --}}
                <x-form.button>
                    <x-form.button-icon>
                        <x-i icon="log-in" size="md" class="icon-md mr-auto" />
                    </x-form.button-icon>
                    Login
                </x-form.button>

                <span>
                    Don't have an account? <a href="/register">Register</a>
                </span>

            </form>
        </div>

        <img src="{{ asset('img/books-table-1.webp') }}" />

    </div>
</x-layouts.app>
