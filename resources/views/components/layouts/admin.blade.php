<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('storage/scripts/tinymce.min.js') }}" referrerpolicy="origin"></script>

    @if (in_array(Route::currentRouteName(), ['events.create', 'events.edit']))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    @endif
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- MAIN --}}
    <x-main full-width>

        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">
            <livewire:admin.sidebar />
        </x-slot:sidebar>

        <x-slot:content>
            <!-- Drawer toggle for "main-drawer" -->
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
            {{ $slot }}
        </x-slot:content>

    </x-main>

    {{--  TOAST area --}}
    <x-toast />

</body>

</html>
