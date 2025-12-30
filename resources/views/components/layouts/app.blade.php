<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <img src="{{ asset('images/cappy-darkmode.svg') }}" alt="Cappy the Application Catalogue" class="w-8 h-8">
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <div class="flex h-24">
                <img src="{{ asset('images/cappy-darkmode.svg') }}" alt="Cappy the Application Catalogue" class="w-12 h-12 ml-4 mt-4">
                <x-header title="Cappy" subtitle="The Application Catalogue" class="ml-4 mt-4"/>
            </div>

            {{-- MENU --}}
            <x-menu activate-by-route>
                {{-- User --}}

                <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
                <div class="text-sm font-semibold mt-4 mb-2">
                    Application Categories
                </div>
                <x-menu-item title="Business" icon="o-briefcase" link="/" />
                <x-menu-item title="Support" icon="o-user-group" link="/" />
                <x-menu-item title="Data" icon="o-circle-stack" link="/" />
                <x-menu-item title="Network" icon="o-wifi" link="/" />
                <x-menu-item title="Hosting" icon="o-server-stack" link="/" />
                <x-menu-item title="Security" icon="o-shield-check" link="/" />
                <x-menu-item title="Other Apps" icon="o-wrench-screwdriver" link="/" />
                
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
