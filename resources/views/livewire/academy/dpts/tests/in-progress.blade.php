<?php

use Barryvdh\Debugbar\Facades\Debugbar;
include_once 'in-progress.php';
?>
<div>
    <livewire:academy.components.dpt-title title='Test rapide' />
    <x-header shadow separator progress-indicator />

    @if ($activeTests)
        @foreach ($activeTests as $test)
            {{-- @dump($test) --}}
            @livewire('academy.dpts.tests.' . $test, ['test' => $test])
            @if (!$loop->last)
                <hr class='my-3'>
            @endif
        @endforeach
    @else
        <i>
            <p class="font-shadow text-cyan-300 text-center text-4xl m-3 tracking-wider">PAS UN SEUL VIEUX TEST DEMANDE*
            </p>
            <p>* : Dé-commenter une ou des lignes dans la fonction <b>showTests()</b> du fichier
                <b>academy/dpts/test/in-progress.php</b>
            </p>
        </i>
    @endif

    <x-partials.size-indicator />
</div>
