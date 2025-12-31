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
            <x-app-brand />
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
            <div class="flex mb-2 h-20">
                    <img src="{{ asset('images/cappy-darkmode.svg') }}" alt="Cappy : The Application Catalogue" class="h-12 mt-4 ml-4">
                    <x-header title="Cappy" subtitle="The Application Catalogue" class="ml-4 mt-4" />
            </div>

            {{-- MENU --}}
                <div class="ml-4 mt-2">
                <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
            </div>
            
                <x-menu activate-by-route>
                    <div class="mb-2 mt-4 text-center">
                        <strong>Application Categories</strong>
                    </div>
                    <x-menu-item title="Business" icon="o-briefcase" link="/" />
                    <x-menu-item title="Support"  icon="o-cpu-chip" link="/" />
                    <x-menu-item title="Data" icon="o-circle-stack" link="/" />
                    <x-menu-item title="Network" icon="o-wifi" link="/" />
                    <x-menu-item title="Hosting" icon="o-server" link="/" />
                    <x-menu-item title="Security" icon="o-shield-check" link="/" />
                    <x-menu-item title="Other" icon="o-wrench-screwdriver" link="/" />
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
