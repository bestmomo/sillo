<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('storage/css/prism.css')}}">
    
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    {{-- IMAGE --}}
    <div class="flex flex-wrap">
        <a href="{{ url('/') }}" class="block w-full">
            <img src="{{ asset('storage/banniere.png') }}" class="w-full" alt="Laravel">
        </a>
    </div>

    {{-- NAVBAR --}}
    <livewire:navigation.navbar :$menus />

    {{-- MAIN --}}
    <x-main full-width>

        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit lg:hidden">
            <livewire:navigation.sidebar :$menus />            
        </x-slot:sidebar>

        {{-- SLOT --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
        
    </x-main>

    {{-- FOOTER --}}
    <hr><br>
        <livewire:navigation.footer /> 
    <br>    

    {{--  TOAST area --}}
    <x-toast />

    <script src="{{ asset('storage/scripts/prism.js')}}"></script>    

</body>
</html>
