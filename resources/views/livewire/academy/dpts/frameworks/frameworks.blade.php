<?php
include_once 'frameworks.php';
?>

<div class='mx-6'>

    <livewire:academy.components.dpt-title title='Frameworks' />
    <x-header shadow separator progress-indicator />

    <p class='  text-center'>Counter: {{ $count }}<br>
        <x-button class="btn-primary mt-1 text-2xl" wire:click.debounce.0ms="increment"><b>+</b></x-button>
        <x-button class="btn-primary mt-1 text-2xl px-5" wire:click.debounce.0ms="decrement"><b>-</b></x-button>
    </p>

    <h1 class='h-[280px] flex items-center'>← Choix dans le menu ci-contre</h1>

    //2fixing <b>Errors on real server :</b><br><br>
    <p>LW / Basics: ← Err 500<br>
        → Essai de retrait du bloc suspect (hello-world)
        car les autres (counter et todo) fonctionne bien dans leurs points de menu respectifs...
        → Nouvelle tentative: Autres codes isolés OK
        → //2ar Nouvelle tentative: Les 3 composants re-activés
    </p>
    <hr>

    <p>ALPINE / GA: Err 500<br>
        → 1ère isolation de code pour voir si encore et 'déjà' erreur...OK</p>
        → //2ar Activation du dernier tab...</p>
    <hr>
    
    <li>
        ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel<br>
        → Devrait fonctionner si .env ou config n'est pas défini à 'dev' mais à prod ou autre.
        //2ar dès que vérifié OK
    </li>

</div>
