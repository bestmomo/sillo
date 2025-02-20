<?php
include_once 'basics.php';
?>

<div class='mx-6'>
	{{-- <livewire:academy.components.page-title title='Bases de Livewire'/> --}}
	<livewire:academy.components.page-title title='Bases de Livewire'/>
	<x-header shadow separator progress-indicator/>

		
	{{-- <livewire:academy.components.page-title title='Bases de LiveWire' /> --}}

	<h1>Simples exemples</h1>

	<livewire:academy.dpts.frameworks.livewire.hello-world/>
	
	<livewire:academy.dpts.frameworks.livewire.counter/>

	{{-- <livewire:academy.dpts.frameworks.livewire.counter by=3/> --}}

  <div class="mt-6">
    <livewire:academy.dpts.frameworks.livewire.Todos />
  </div>

</div>

