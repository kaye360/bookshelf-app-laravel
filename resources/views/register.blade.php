<x-layouts.app>

    <register-columns class="grid grid-cols-2 mx-auto w-fit gap-24 items-center">

        <div class="grid gap-4">
            <x-h1>
                Organize your bookshelf today!
            </x-h1>

            <form method="POST" action="/register" class="grid gap-5">
                @csrf

                <label>
                    <span class="font-semibold">Username</span><br />
                    <x-form.input type="text" name="username" />
                    @error('username')
                        <span class="text-rose-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>

                <label>
                    <span class="font-semibold">Email</span><br />
                    <x-form.input type="email" name="email" />
                    @error('email')
                    <span class="text-rose-500">
                        {{ $message }}
                    </span>
                @enderror
                </label>

                <label>
                    <span class="font-semibold">Password</span><br />
                    <x-form.input type="password" name="password" />
                    @error('password')
                    <span class="text-rose-500">
                        {{ $message }}
                    </span>
                @enderror
                </label>

                <label>
                    <span class="font-semibold">Confirm Password</span><br />
                    <x-form.input type="password" name="password_confirmation" />
                    @error('password_confirmation')
                    <span class="text-rose-500">
                        {{ $message }}
                    </span>
                @enderror
                </label>

                <x-form.button>
                    <x-slot:icon>
                        <x-i icon="user-plus" size="md" class="icon-md mr-auto" />
                    </x-slot:icon>
                    Sign Up
                </x-form.button>

                <span>
                    Already have an account? <a href="/login">Login</a>
                </span>

            </form>

        </div>

        <img src="{{ asset('img/books-table-2.webp') }}" />

    </register-columns>

</x-layouts.app>
