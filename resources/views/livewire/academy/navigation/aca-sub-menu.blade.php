@php
    include '../resources/views/livewire/academy/navigation/btns.php';
@endphp

{{-- <x-nav sticky full-width class='flex w-full !justify-items-stretch !my-0 !py-0 border border-blue-500 gap-0'> --}}
<x-nav sticky full-width class='shadow-tr shadow-white !py-0'>

    <x-slot:brand>
        <div>
            <span><a class='font-shadow text-2xl text-gray-300 tracking-wider' href="{{ route('home') }}"
                title=" {{ __('Public Home') }} ">{{ strtoupper(__('Home')) }}</a></span>
                <div class='text-sm text-gray-400 text-center md:inline md:ml-2'>v.{{ config('app.version') }}</div>
            </div>
    </x-slot:brand>

    <x-slot:actions>

        <div class="flex flex-wrap justify-center items-center gap-y-2">

            @foreach ($btns as $k => $btn)
                <x-button label="{{ $k }}" title="{{ $btn['title'] }}" icon="{{ $btn['icon'] }}"
                    link="{{ route($btn['routeLink']) }}" @class(['btn-ghost btn-sm font-new text-lg', $btn['css']]) responsive />
            @endforeach

            @if (auth()?->user()?->isAdmin())
                <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="ml-6 btn-outline font-new"
                    link="{{ route('admin') }}" />
            @endif

        </div>
    </x-slot:actions>
</x-nav>
<x-partials.size-indicator />
