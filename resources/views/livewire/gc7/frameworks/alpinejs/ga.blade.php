<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.gc7.main')] class extends Component {
    //
}; ?>

<div>
    <x-header class="mb-0" title="GA" shadow separator progress-indicator></x-header>

<div x-data="{ choice: null, btnstyle: 'primary' }">
    
    <p x-text="btnstyle"></p>
    
    <x-button x-on:click="choice='spoiler'; btnstyle = 'secondary'" 
    class="btn-sm btn-primary"
    >Spoiler <span x-text="btnstyle"></span></x-button>



        
        
        
        
        {{-- <x-button class='btn-secondary btn-sm' @click="choice='tabs'; btnstyle = 'secondary'">Onglets</x-button> --}}
        
        <hr class="mt-1">
        
        {{-- <div x-cloak x-transition.duration.700ms x-show="choice == 'spoiler'"> --}}
            {{-- @include('livewire.gc7.frameworks.alpinejs.ga.01_bases') --}}
        {{-- </div> --}}

        {{-- <div x-cloak x-transition.duration.700ms x-show="choice == 'tabs'"> --}}
            {{-- @include('livewire.gc7.frameworks.alpinejs.ga.02_bases') --}}
        {{-- </div> --}}

        {{-- @include('livewire.gc7.frameworks.alpinejs.ga.77_bases') --}}
    </div>
</div>
