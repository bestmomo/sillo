<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Chats')] #[Layout('components.layouts.academy')] class extends Component {
	public $subtitle     = 'V1 ou V2 ?';
	protected $listeners = ['update-subtitle' => 'updateSubtitle'];

	public function updateSubtitle($newSubtitle)
	{
		$this->subtitle = $newSubtitle;
	}
}; ?>

<div class="relative w-full h-screen">

    <x-header title="Chat {{ $subtitle ?? '' }}" shadow separator progress-indicator></x-header>

    @php
        $nochoice = '<div class="absolute" x-cloak x-transition.opacity.duration.777ms x-show="choice != &quot;V1&quot; && choice !=&quot;V2&quot;">
    <h1>Choose v1 or v2, please !</h1><hr>You need start the Broadcasting channel server:<br><b>php .\artisan reverb:start</b><hr>To see events in the CLI: resources/js/echo.js</div>';
    @endphp

    @livewire('academy.helpers.chats-submenu', ['nochoice' => $nochoice, 'btns' => ['V1', 'V2']])

    {{-- <hr>
    
    Note: You need :
    
    php .\artisan reverb:start --}}
</div>
