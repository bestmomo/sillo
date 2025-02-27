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
    
    
    //2fix Errors on real server :
    <ul>
        <li>
            LW / Basics: ← Err 500 on real server is certainly here --}}
        </li>
        <li>
            LW / Blog: Faire pour réel SIMU des deletes<br>
        </li>
        <li>
            LW / New Post: Err 500<br>
        </li>
        <li>
            LW / NesForm: En réel, pas de calcul des caractères<br>
        </li>
        <li>
            ALPINE / GA: Err 500<br>
        </li>
        <li>
            ALPINE / Chats : Le point de menu n'est pas sensé apparaître en réel<br>
        </li>
    </ul>
    
</div>
