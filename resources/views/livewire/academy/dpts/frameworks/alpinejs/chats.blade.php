<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Chats')] #[Layout('components.layouts.academy')] class extends Component
{
	public $subtitle     = 'V1 ou V2 ?';
	protected $listeners = ['update-subtitle' => 'updateSubtitle'];

	public function updateSubtitle($newSubtitle)
	{
		$this->subtitle = $newSubtitle;
	}
}; ?>

<div class="relative w-full h-screen">

    @if (config('app.env') === 'production')
        <livewire:academy.components.page-title title="Chat... Mais...?"/>
        <p class='text-center text-green-400 font-new font-bold text-xl mt-6'>... À se demander comment vous êtes arrivé là ?!?</p>
        
        <div x-data="countdown()">
            <p class='text-center text-xl' x-text="`Et ce, depuis ${count} secondes maintenant !`"></p>
            <template x-if="count < 4">
                <p class='text-center text-xl' x-text="`Allez...`" />
            </template>
            <template x-if="count < 2">
                <p class='text-center text-7xl font-shadow text-green-400'>BYE !!!</p>
            </template>
            <template x-if="count === 0">
                <p class='text-right'><i>7 secondes de trop !</i></p>
                <a href="{{ route('home') }}">Rediriger vers la route</a>
            </template>
        </div>
        
        <script>
            function countdown() {
                return {
                    count: 7,
                    init() {
                        this.startCountdown();
                    },
                    startCountdown() {
                        this.interval = setInterval(() => {
                            this.count -= 1;
                            if (this.count === 0) {
                                clearInterval(this.interval);
                                 window.location.href = "{{ route('home') }}";
                            }
                        }, 1000);
                    }
                }
            }
        </script>
    @else
    LOCAL
    
    si dev 👌 sinon  pas encore installé en réel... equipe sille.
    
    
    <livewire:academy.components.page-title title="Chat...: {{ $subtitle ?? '' }}"/>
    
    @php
        $nochoice = '<div class="absolute" x-cloak x-transition.opacity.duration.777ms x-show="choice != &quot;V1&quot; && choice !=&quot;V2&quot;">
    <h1>Choose v1 or v2, please !</h1><hr>You need start the Broadcasting channel server:<br><b>php .\artisan reverb:start</b><hr>To see events in the CLI: resources/js/echo.js</div>';
    @endphp

    @livewire('academy.helpers.chats-submenu', ['nochoice' => $nochoice, 'btns' => ['V1', 'V2']])

    <hr>
    
    Note: You need :
    
    php .\artisan reverb:start
    @endif
</div>
