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
        → 1.00.04 : Nouvelle tentative: Suppression d'un x-header en trop (Tous les (3) composants re-activés) et respect de la casse pour l'appel du dernier composant.<br>
        → 1.00.03 : Essai de retrait du bloc suspect (hello-world) car les autres (counter et todo) fonctionne bien dans leurs points de menu respectifs...
    </li>
    
    <hr class='my-3'>

    <li><b>ALPINE / GA: Activation du dernier tab => Err 500</b><br>
        → 1.00.04 : Activation du dernier tab, mais n'est laissé que l'import des fichiers CSS<br>
        → 1.00.03 : 1ère isolation de code pour voir si encore et 'déjà' erreur... 3ème tab (Tabs) => Err 500<br>
    </li>
    
    <hr class='my-3'>

    <li><b>ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel</b><br>
        1.00.04 : <br>
        1.00.03 : .env ou config bien non défini à 'dev' mais menu toujours présent :-(
    </li>

    <hr class='my-3'>

    <li>
        <b>Tests / Listing fake academy_users pas conforme à academy_users ?!?</b></br>
        1.00.04 : Sans doute supprimer la table 'academy_users_4_tests'/ BestMomo... Ce qui la fera se re-générer lors du prochain appel de la page.<br>
        (C'est la même que 'academy_users', sauf que l'id 1 (Marc Hautpolo) est relayé à l'id 777, et tous les autres sont ré-indexés)
    </li>
    <br>
</div>
