<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Adonis Abbey </title>
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="/assets/css/tailwind.output.css" /> --}}

    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="/assets/js/init-alpine.js"></script> --}}
</head>

<body>
    <div class="relative flex items-center min-h-screen p-6">

        <div class="flex-1 h-full max-w-md mx-auto overflow-hidden bg-white rounded-lg shadow-xl">
            <div class="flex flex-col pt-4 space-y-4 overflow-y-auto">
                <div class="pt-4">
                    <img aria-hidden="true" class="object-cover w-40 mx-auto" src="/img/logo.png" alt="Office" />
                </div>
                <div class="flex items-center justify-center px-6 pt-0 pb-6 sm:p-12 sm:pt-0">
                    <div class="w-full">

                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <label class="block text-sm">
                                <span class="text-gray-600">Email</span>
                                <input name="email" type="text" value="{{ old('email') }}"
                                    class="block w-full mt-1 text-sm form-input focus:border-primary focus:outline-none"
                                    placeholder="Janedoe@adonis-abbey.com" />
                                @error('email')
                                    <span class="text-sm font-normal text-red-600">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-600">Password</span>
                                <input name="password" value="{{ old('password') }}"
                                    class="block w-full mt-1 text-sm form-input focus:border-primary focus:outline-none"
                                    placeholder="***************" type="password" />
                                @error('password')
                                    <span class="text-sm font-normal text-red-600">{{ $message }}</span>
                                @enderror
                            </label>
                            <p class="text-right">
                                <a class="text-sm font-medium text-right text-secondary hover:underline"
                                    href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            </p>

                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button type="submit"
                                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg bg-primary focus:shadow-outline-green hover:bg-primary focus:outline-none active:bg-primary"
                                href="/index.html">
                                Log in
                            </button>
                        </form>

                        <hr class="my-8" />
                        <p class="mt-1 text-center">
                            <span>New Author</span>
                            <a class="text-sm font-medium text-secondary hover:underline"
                                href="{{ route('register') }}">
                                Create an account
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
