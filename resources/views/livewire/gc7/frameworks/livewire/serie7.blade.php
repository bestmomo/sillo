<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new 
#[Title('Serie7')] 
#[Layout('components.layouts.gc7.main')] 
class extends Component {
    //
}; ?>

<div>
    @php
        $btns = ['Users'];
    @endphp
    {{-- <x-header class="mb-0" title="Série 7" shadow separator progress-indicator></x-header> --}}

    @include('livewire.gc7.frameworks.livewire.serie7.00_submenu', ['btns' => json_encode($btns)])
</div>
