<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('Serie7')] #[Layout('components.layouts.gc7.main')] class extends Component {
    public $btns = ['Users', 'Infinite_Scroll', 'Offset'];

}; ?>
<div x-data="{ choice: 'menuLivewire' }" class="w-full">

    @section('styles')
        <style>
            .drawer-content {
                padding: 0;
            }

            .btn-menu {
                color: #ccc;
                transition: .5s ease-in-out;
            }

            .btn-menu.active {
                font-weight: bold;
                color: orange;
            }

            .btn-menu:hover {
                color: #c7cf2f;
            }
        </style>
    @endsection

    @php
        $uuu = 777;
    @endphp

    <x-header class="p-3 pb-0" title="Série 7 {{ $uuu }}" shadow separator progress-indicator />

    {{-- Subtitle: {{ $subtitle }} --}}

    <nav class='w-full flex flex-wrap justify-evenly py-3'>
        <button @click="choice = 'menuLivewire'" class="btn-menu" :class="{ 'active': choice === 'menuLivewire' }">SubMenu
            Livewire</button>
        <button @click="choice = 'menuAlpineJs'" class="btn-menu" :class="{ 'active': choice === 'menuAlpineJs' }">SubMenu
            AlpineJS</button>
    </nav>
    <hr class="mb-3">
    <div x-show="choice=='menuLivewire'" x-cloak x-transition.duration.300ms>
        <livewire:gc7.frameworks.livewire.serie7.00_submenu_livewire :btns=$btns />
    </div>
    <div x-show="choice=='menuAlpineJs'" x-cloak x-transition.duration.300ms>
        <livewire:gc7.frameworks.livewire.serie7.00_submenu_alpine :btns=$btns />
    </div>
</div>

{{-- <livewire:gc7.frameworks.livewire.serie7.00_submenu /> --}}
