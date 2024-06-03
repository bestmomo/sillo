<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    <x-main full-width>
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- FOOTER --}}
    <hr><br>

    <footer class="flex justify-center gap-x-2 text-gray-200">
        <a href="/" class="hover:text-gray-500 mr-2">
            @lang('Home')
        </a>
        <a href="#" class=" hover:text-gray-500 mr-2">
            @lang('About')
        </a>
        <a href="/contact" class=" hover:text-gray-500 mr-2">
            @lang('Contact')
        </a>
        <div>© 2024 - Bestmomo</div>     
    </footer>
    <br>

    {{--  TOAST area --}}
    <x-toast />
    
</body>
</html>
