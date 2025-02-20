<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Title('Chats')] #[Layout('components.layouts.academy')] class extends Component {
    public $subtitle = 'V1 ou V2 ?';
    protected $listeners = ['update-subtitle' => 'updateSubtitle'];

    public function updateSubtitle($newSubtitle)
    {
        $this->subtitle = $newSubtitle;
    }

    public function isReverbServerRunning($url = 'http://localhost:8080')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);

        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode >= 100 && $httpcode < 600;
    }
}; ?>

<div class='relative w-full h-screen mx-6'>

    @php
        // function isServerRunning($url)
        // {
        //     $ch = curl_init($url);
        //     curl_setopt($ch, CURLOPT_NOBODY, true);
        //     curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_FAILONERROR, false);

        //     curl_exec($ch);
        //     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //     curl_close($ch);

        //     return $httpcode >= 100 && $httpcode < 600; // Any HTTP status code indicates the server is responding
        // }

        // $server_url = 'http://localhost:8080';
        // if (isServerRunning($server_url)) {
        //     echo "Le serveur est en cours d'exécution.";
        // } else {
        //     echo "Le serveur ne fonctionne pas.";
        // }
    @endphp
    @if (config('app.env') === 'production')
        <livewire:academy.components.page-title title="Chat... Mais...?" />
        <p class='text-center text-green-400 font-new font-bold text-xl mt-6'>... À se demander comment vous êtes arrivé
            là ?!?</p>

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
        @if (!$this->isReverbServerRunning())
            <livewire:academy.components.page-title title="Chat...: Vous devez démarrer le serveur 'reverb' !" />
            <x-header shadow separator progress-indicator />

            <p class='text-italic text-white mt-6'>Pour lancer le serveur, en CLI :</p>
            <p class='font-bold mt-6 border-2 border-white rounded-lg text-center bg-red-500 text-black p-3'>
                php .\artisan reverb:start
            </p>
        @else
            <livewire:academy.components.page-title title="Chat...: {{ $subtitle ?? '' }}" />
            <x-header shadow separator progress-indicator />

            @php
                $nochoice = '<div class="absolute" x-cloak x-transition.opacity.duration.777ms x-show="choice != &quot;V1&quot; && choice !=&quot;V2&quot;">
                <h1>Choose v1 or v2, please !</h1>
                <hr>To see events in the CLI: resources/js/echo.js</div>';
            @endphp

            @livewire('academy.helpers.chats-submenu', ['nochoice' => $nochoice, 'btns' => ['V1', 'V2']])
        @endif
    @endif
</div>
