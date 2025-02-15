<?php
include_once 'soluce1.php'; ?>

@section('title', __('Test'))
<div class="container mx-auto">

    <x-header title="{{ __('Products') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce.300ms="search" clearable
                icon="o-magnifying-glass" />
                <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

@include('livewire.admin.tests.tableFilter.submenu')

    {{-- <img src="{{ asset('storage/imgs/test-tube-icon.svg') }}" alt="Description de l'image"> --}}
                {{-- <img src="{{ asset('storage/photos/test-icon.svg') }}" alt="Description de l'image"> --}}

                {{-- <x-icon test-tube-icon /> --}}

    <div class="mt-4 !px-24 ml-12">
        @if ($items->count())
            <div class="grid gap-4">
                @foreach ($items as $item)
                    <div class="text-lg p-4 bg-base-100 rounded shadow">
                        {{ $item->name }}
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        @else
            <p>
                @if ($items->needRefresh)
                    {{ __('Please wait... Opening a valid page...') }}
                    @else
                    {{ __('No result') }}.
                @endif
            </p>

        @endif
    </div>
</div>
