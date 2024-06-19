<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('GA')] #[Layout('components.layouts.gc7.main')] class extends Component {
    //
}; ?>

<div>
    <x-header title="GA" shadow separator progress-indicator></x-header>
    
    {{-- @include('livewire.gc7.frameworks.alpinejs.ga.01_bases') --}}
    @include('livewire.gc7.frameworks.alpinejs.ga.02_bases')
    
    
    {{-- @include('livewire.gc7.frameworks.alpinejs.ga.77_bases') --}}
</div>
