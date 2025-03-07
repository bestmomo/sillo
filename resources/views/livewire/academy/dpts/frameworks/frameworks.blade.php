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

    <div class='mb-6'>
        <span class="hidden">//2fixing</span><span class='text-red-600 text-xl font-bold'>Erreurs sur le serveur
            distant en cours de résolution :</span>
    </div>

    <li><b>LW / Basics => Err 500</b><br>
        → 1.00.04 : Nouvelle tentative: Suppression d'un x-header en trop (Les 3 composants re-activés)<br>
        → 1.00.03 : Essai de retrait du bloc suspect (hello-world) car les autres (counter et todo) fonctionne bien dans leurs points de menu respectifs...
    </li>
    
    <hr class='my-3'>

    <li><b>ALPINE / GA: Activation du dernier tab => Err 500</b><br>
        → 1.00.04 : Activation du dernier tab, mais n'est laissé que l'import des fichiers CSS<br>
        → 1.00.03 : 1ère isolation de code pour voir si encore et 'déjà' erreur... 3ème tab (Tabs) => Err 500<br>
    </li>
    
    <hr class='my-3'>

    <li>
        ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel<br>
        → Devrait fonctionner si .env ou config n'est pas défini à 'dev' mais à prod ou autre.
        //2ar dès que vérifié OK
    </li>

    <hr class='my-3'>

    <li>
        Test / Listing fake academy_users no same as academy_users ?!?
    </li>
    <br>
</div>
