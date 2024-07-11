<?php
// Sub MENU Livewire
include_once '00_L_submenu.php';
?>

<div x-data="{ choice: @entangle('choice') }">
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Btns" shadow separator progress-indicator /> --}}

    <div class="mb-3">
        <h2 class="text-center text-2xl mb-3 font-bold">Sub MENU Livewire</h2>

        <div class='flex flex-wrap justify-around mx-auto gap-3 gap-y-3'>
            @foreach ($btns as $btn)
                {{-- <span x-text="choice"></span> --}}
                <button wire:click="setChoice('{{ $btn }}')" class="mr-3 btn btn-sm mb-0 pb-0"
                    :class="choice !== '{{ $btn }}' ? 'btn-primary' : 'btn-secondary'"
                    x-transition.duration.2000ms id={{ $btn }}>
                    {{ $btn }}
                </button>
            @endforeach
        </div>
        <x-header class="mb-0 px-4" shadow separator progress-indicator />
    </div>

    @php
        $component = $this->getComponentName($choice);
    @endphp
    <div class='flex flex-wrap justify-between gap-1 mt-[-22px] pt-0 sm:px-5'>
        <div class="flex-1 text-center min-w-[20%]"><small>CHOICE PHP</small>: {{ $choice }}</div>
        <div class="flex-shrink-0 text-center"> - </div>
        <div class="flex-1 text-center min-w-[20%]"><small>CHOICE JS</small>: <span x-text="choice"></span></div>
        <div class="flex-shrink-0 text-center"> → </div>
        <div class="flex-1 text-center min-w-[20%]"><small>COMPONENT PHP</small>: {{ $component }}</div>
    </div>

    @if ($component)
        @livewire('academy.frameworks.livewire.serie7.' . $component, key($component))
    @endif

</div>
