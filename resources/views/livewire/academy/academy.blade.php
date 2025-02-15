<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Academy')]
#[Layout('components.layouts.acaLight')]
class extends Component
{
}; ?>

<div>
    <x-header title="ACADÉMIE" shadow separator progress-indicator>
    </x-header>
    
    @if (!Str::startsWith(config('app.locale'), 'fr'))
        <x-card separator class="my-3 -mt-3 bg-error text-center text-xl text-white font-bold shadow-xl">
            ⚠️ Please note that this section is exclusively in French. The refined and adopted versions, however, will be
            multi-language and online 🙂 !
        </x-card>
    @endif
    
    <h2>(Page d'accueil de l'académie)</p>
        <p>//2do Présentation</p>
        - Étude<br>
        - T.P. (Travaux Pratiques)<br>
        //2do  N° 1 → // filter / table...
        <p>//2do Outils préconisés</p>
        <p>//2do Mode d'emploi</p>
</div>
