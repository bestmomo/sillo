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

    <div id="markdown-content"></div>

    //2fixing <b>Errors on real server :</b><br><br>
    <p>LW / Basics: ← Err 500<br>
        → Essai de retrait du bloc suspect (hello-world)
        car les autres (counter et todo) fonctionne bien dans leurs points de menu respectifs...</p>
    <hr>
    <p>LW / Blog: Faire SIMU des deletes<br>
        → Méthode delete(), function $post->delete() inactive (et message Toast adapté) si pas en 'dev' ou $postId > 9.
    </p>
    <hr>
    <p>LW / New Post: Err 500<br>
        → Code du form commenté, pour voir si erreur persiste et est avant le form...</p>
    <hr>
    <p>LW / NewForm: Pas de calcul du nombre de caractères<br>
        → Bug certainement dû si env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM') n'a pas été défini → Fixé ?</p>
    <hr>
    <p>ALPINE / GA: Err 500<br>
        → 1ère isolation de code pour voir si encore et 'déjà' erreur....</p>
    <hr>
    <li>
        ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel<br>
        → Devrait fonctionner si .env ou config n'est pas défini à 'dev' mais à prod ou autre.
    </li>

</div>
