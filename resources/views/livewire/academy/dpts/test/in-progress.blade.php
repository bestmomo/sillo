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
        @livewire('academy.dpts.test.stats-users', ['testName' => $activeTests])
    @elseif (in_array('normalize', $activeTests))
        @livewire('academy.dpts.test.normalize', ['testName' => $activeTests])
    @elseif (0)
        {{-- Autre 'vieux' test --}}
    @else
        {{-- !flex !flex-none text-center !m-0 !p-0 --}}<i><x-header class="flex font-shadow text-primary !justify-center text-center"
                title="PAS UN SEUL VIEUX TEST DEMANDE" icon="o-check" shadow separator progress-indicator /> </i>
    @endif

    <hr class='my-3'>

    <x-partials.size-indicator />
</div>
