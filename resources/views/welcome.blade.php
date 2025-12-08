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

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <img src="{{ asset('images/cappy.svg') }}" alt="Cappy Logo" class="logo">
    <h1 class="welcome-title text-gray-900 dark:text-white">Hello and welcome to Cappy</h1>
    <p class="welcome-subtitle text-gray-700 dark:text-gray-300 mb-6">The application catalogue</p>
    <div class="m-6">
        <a href="/admin/login"
            class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-full border-2 border-gray-500 hover:border-gray-600 transition-colors duration-200 shadow-sm"
            style="background-color: #6b7280 !important; padding: 12px !important;">
            Visit the admin panel
        </a>
    </div>
</body>

</html>