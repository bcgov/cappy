<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json' )) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    {{-- 
        *** CHANGE 1: Updated the body tag ***
        Added 'dark:text-[#EDEDEC]' to ensure all inherited text is light in dark mode.
    --}}
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        @if (Route::has('login'))
            <header class="grid grid-cols-2 w-full max-w-7xl">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <nav class="-mx-3 flex flex-1 justify-end">
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
        <img src="{{ asset('images/cappy.svg') }}" alt="Cappy Logo" class="logo">
        
        {{-- 
            *** CHANGE 2: Updated the heading tag ***
            Added 'text-gray-900' for light mode and 'dark:text-white' for dark mode.
        --}}
        <h1 class="welcome-title text-gray-900 dark:text-white">Hello and welcome to Cappy</h1>
        
        {{-- 
            *** CHANGE 3: Updated the subtitle tag ***
            Added 'text-gray-700' for light mode and 'dark:text-gray-300' for dark mode.
        --}}
        <p class="welcome-subtitle text-gray-700 dark:text-gray-300">The application catalogue</p>
        
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
