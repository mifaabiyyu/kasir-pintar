<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex justify-between bg-gray-900">
            <div class="sm:fixed sm:top-0 sm:left-0 p-6 text-left z-10">
                <a href="{{ url('/') }}" class=" {{ request()->is('/') ? 'text-white' : '' }} font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                <a href="{{ url('/items') }}" class="{{ request()->is('items') ? 'text-white' : '' }} ml-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 ">Item</a>
                @auth
                <a href="{{ url('transaction') }}" class="{{ request()->is('transaction') ? 'text-white' : '' }} ml-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log Item</a>
                <a href="{{ url('categories') }}" class="{{ request()->is('categories') ? 'text-white' : '' }} ml-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Category</a>
                <a href="{{ url('/satuan') }}" class="{{ request()->is('satuan') ? 'text-white' : '' }}  ml-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Satuan</a>
                <a href="{{ url('/vendor') }}" class="{{ request()->is('vendor') ? 'text-white' : '' }}  ml-4 font-semibold text-gray-900 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Vendor</a>
                @endauth
            </div>
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right ">
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
    
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-900 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>