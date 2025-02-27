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

    //2fix <b>Errors on real server :</b><br><br>
    <ul>
        <li>
            LW / Basics: ← Err 500<br>
            → Essai de retrait du bloc suspect (hello-world)
            car les autres (counter et todo) fonctionne bien dans leur point de menu...<hr>
        </li>
        <li>
            LW / Blog: Faire SIMU des deletes<br>
            → Méthode delete(), function $post->delete() inactive (et message Toast adapté) si pas en 'dev'.
        </li>
        <li>
            LW / New Post: Err 500<br>
        </li>
        <li>
            LW / NewForm: Pas de calcul des caractères<br>
        </li>
        <li>
            ALPINE / GA: Err 500<br>
        </li>
        <li>
            ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel<br>
            → Devrait fonctionner si .env ou config n'est pas défini à 'dev' mais à prod
        </li>
    <ul>

</div>
