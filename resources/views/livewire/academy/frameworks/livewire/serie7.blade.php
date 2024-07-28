<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Serie7')] #[Layout('components.layouts.academy')] class extends Component {
	public $btns         = ['Users', 'Infinite_Scroll', 'Offset', 'Api', 'Test'];
	public $btnToClick   = 'Users'; // btn de la liste ci-dessus à auto cliquer
	public $subtitle     = 'Chargement...';
	protected $listeners = ['update-subtitle' => 'updateSubtitle'];

	public function updateSubtitle($newSubtitle)
	{
		$this->subtitle = $newSubtitle;
		logger('Subtitle updated to: ' . $newSubtitle);
	}
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

    <x-header class="p-4 pb-0 mb-[-12px]" title="Serie 7  - {{ $subtitle }}" shadow separator progress-indicator />

    {{-- Subtitle: {{ $subtitle }} --}}

    <nav class='w-full flex flex-wrap justify-evenly mb-3'>
        <button @click="choice = 'menuLivewire'" class="btn-menu" :class="{ 'active': choice === 'menuLivewire' }">SubMenu
            Livewire</button>
        <button @click="choice = 'menuAlpineJs'" class="btn-menu" :class="{ 'active': choice === 'menuAlpineJs' }">SubMenu
            AlpineJS</button>
    </nav>
    <hr class="mb-2">
    <div x-show="choice=='menuLivewire'" x-cloak x-transition.duration.300ms>
        <livewire:academy.frameworks.livewire.serie7.00_L_submenu_livewire :btns=$btns />
    </div>
    <div x-show="choice=='menuAlpineJs'" x-cloak x-transition.duration.300ms>
        <livewire:academy.frameworks.livewire.serie7.00_A_submenu_alpine :btns=$btns />
    </div>

    <script>
        let btnToClick = @js($btnToClick);
        console.log('JS cliquera sur le bouton ' + btnToClick);
    </script>
    @include('livewire.academy.frameworks.livewire.serie7.00_click')

</div>
