<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use Livewire\Volt\Component;

new class() extends Component {
	public $btns;
	public $choice;

	public function setChoice($btn)
	{
		$this->choice = $btn;
	}

	public function getComponentName($choice): string
	{
		return strtolower($this->choice);
	}
}; ?>

<div x-data="{ choice: @entangle('choice') }">
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Btns" shadow separator progress-indicator /> --}}

    <div class="mb-3">
        <h2 class="text-center text-2xl mb-3 font-bold">Sub MENU AlpineJS</h2>
        {{-- //2do subMenu AlpineJS --}}
        <div class='flex justify-between'>
            @foreach ($btns as $btn)
                {{-- <span x-text="choice"></span> --}}
                <button wire:click="setChoice('{{ $btn }}')" class="mr-3 btn btn-sm mb-0 pb-0"
                    :class="choice !== '{{ $btn }}' ? 'btn-primary' : 'btn-secondary'"
                    x-transition.duration.2000ms id={{ $btn }}>
                    {{ $btn }}
                </button>
            @endforeach
        </div>
        <x-header class="mb-0 pt-0" shadow separator progress-indicator />
    </div>

    <div class='flex justify-evenly'>
        <span>CHOICE PHP: {{ $choice }}</span>
        <span> - </span>
        <span>CHOICE JS: <span x-text="choice"></span></span>
    </div>

    <hr class="mt-20">

    {{-- <livewire:academy.frameworks.livewire.serie7.00_click/> --}}

    {{--
    --}}


    {{-- @livewire('academy.frameworks.livewire.serie7.01_users') --}}


    <!-- Display the active component -->
    {{-- @foreach ($this->getComponents() as $component)
        @ if ($activeComponent === $component['name'])
            <div>
                <livewire:academy.frameworks.livewire.serie7.' . strtolower($component['name']) />
            </div>
        @endif
    @endforeach --}}

</div>
