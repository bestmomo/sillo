<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Académie')]
#[Layout('components.layouts.acaLight')]
class extends Component
{
}; ?>

<div>
    <x-header title="ACADÉMIE" shadow separator progress-indicator>
    </x-header>
    
    <h2>(Page d'accueil de l'académie)</p>
        <p>//2do Présentation</p>
        - Étude<br>
        - T.P. (Travaux Pratiques)<br>
        //2do  N° 1 → // filter / table...
        <p>//2do Outils préconisés</p>
        <p>//2do Mode d'emploi</p>
</div>
