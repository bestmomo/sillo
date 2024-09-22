<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    @vite(['resources/css/app.css', 'resources/css/academy-styles.css', 'resources/js/app.js'])

    @yield('styles')
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-[#1c232b]">

    <div class="flex">

        <livewire:academy.aside-menu />

        <x-main full-width>
            <x-slot:content>
                {{ $slot }}
            </x-slot:content>
        </x-main>

    </div>


    {{-- FOOTER --}}
    {{-- <div class="h-[300px] relative clear-both"> --}}
    <div class="h-[70px]">
        <hr style="color:red"><br>
        <livewire:navigation.footer />
        <br>
    </div>

    {{--  TOAST area --}}
    <x-toast />

    @yield('scripts')

</body>

</html>
