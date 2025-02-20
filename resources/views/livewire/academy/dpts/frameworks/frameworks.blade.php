<?php
include_once 'frameworks.php';
?>

<div>
    <livewire:academy.components.dpt-title title='Frameworks' />
    <x-header shadow separator progress-indicator />

    <p class='text-center'>Counter: {{ $count }}<br>
        <x-button class="btn-primary mt-1 text-2xl" wire:click.debounce.0ms="increment"><b>+</b></x-button>
        <x-button class="btn-primary mt-1 text-2xl px-5" wire:click.debounce.0ms="decrement"><b>-</b></x-button>
    </p>

    <h1 class='h-[280px] flex items-center'>← Choix dans le menu ci-contre</h1>
</div>
