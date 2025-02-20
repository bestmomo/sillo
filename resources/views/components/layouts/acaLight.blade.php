<!DOCTYPE html>
<html lang="{{ substr(config('app.locale', 'fr'), 0, 2) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}
    </title>

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    {{-- //2do link icons --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    @include('livewire.academy.navigation.aca-sub-menu')

    @include('livewire.academy.partials.disclaimer')

    <x-main full-width>
        <x-slot:content class='!pt-0 !px-6'>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- FOOTER --}}
    {{-- <hr><br>
            <livewire:navigation.footer />
            <br> --}}

    {{-- TOAST area --}}
    <x-toast />

</body>

</html>
