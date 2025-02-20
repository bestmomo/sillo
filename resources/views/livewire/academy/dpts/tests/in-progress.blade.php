<?php

use Barryvdh\Debugbar\Facades\Debugbar;
include_once 'in-progress.php';
?>
<div>
    <livewire:academy.components.dpt-title title='Test rapide' />
    <x-header shadow separator progress-indicator/>

    <h1>Ready.</h1>

    <hr class='my-3'>

    @if (in_array('stats-users', $activeTests))
        @livewire('academy.dpts.tests.stats-users', ['testsNames' => $activeTests])
    @endif
    @if (in_array('normalize', $activeTests))
        @livewire('academy.dpts.tests.normalize', ['testsNames' => $activeTests])
    @endif
    @if (in_array('faker', $activeTests))
        @livewire('academy.dpts.tests.faker', ['testsNames' => $activeTests])
    @endif
    @if ($activeTests)
        {{-- Autre 'vieux' test --}}
    @else
        <i><p class="font-shadow text-cyan-300 text-center text-4xl m-3 tracking-wider">PAS UN SEUL VIEUX TEST DEMANDE*</p>
            <p>* : Dé-commenter une ou des lignes dans la fonction <b>showTests()</b> du fichier <b>academy/dpts/test/in-progress.php</b></p></i>
    @endif

    <hr class='my-3'>

    <x-partials.size-indicator />
</div>
