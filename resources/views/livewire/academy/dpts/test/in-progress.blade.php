<?php

use Barryvdh\Debugbar\Facades\Debugbar;
include_once 'in-progress.php';
?>
<div>
	<x-header class="font-shadow text-green-400" title="TEST RAPIDE" icon="o-check" shadow separator progress-indicator/>

	<h1>Ready.</h1>

	<hr class='my-3'>

	<p>Ton écran actuel :<x-partials.size-indicator/></p>

	<hr class='my-3'>

	@if ($activeTests[0] ?? null == 'stats-users')
		@livewire('academy.dpts.test.stats-users', ['testName' => $activeTests[0]])

	@elseif (0)
		{{-- Autre 'vieux' test --}}
	@else
		{{-- !flex !flex-none text-center !m-0 !p-0 --}}<i><x-header class="flex font-shadow text-primary !justify-center text-center" title="PAS UN SEUL VIEUX TEST DEMANDE" icon="o-check" shadow separator progress-indicator/> </i>
	@endif


	{{-- @livewire('academy.dpts.test.stats-users', ['testName'=>$activeTests[0]]) --}}
	{{-- <livewire:academy.dpts.test.statsUsers:$name /> --}}
</div>

