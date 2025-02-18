<?php

use Barryvdh\Debugbar\Facades\Debugbar;
include_once 'in-progress.php';
?>
<div>
	<x-header class="font-shadow text-green-400" title="TEST RAPIDE" icon="o-check" shadow separator progress-indicator/>

	<h1>Ready.</h1>

	<x-partials.size-indicator/>

	<hr class='my-3'>


	@if ($activeTests[0] ?? null == 'stats-users')
		@livewire('academy.dpts.test.stats-users', ['testName' => $activeTests[0]])

	@elseif (0)
		{{-- Autre 'vieux' test --}}
	@else
		{{-- !flex !flex-none text-center !m-0 !p-0 --}}

		<x-header
	class="flex font-shadow text-primary !justify-center text-center" title="PAS DE VIEUX TEST DEMANDE" icon="o-check" shadow separator progress-indicator/> @endif


	{{-- @livewire('academy.dpts.test.stats-users', ['testName'=>$activeTests[0]]) --}}
	{{-- <livewire:academy.dpts.test.statsUsers:$name /> --}}
</div>

