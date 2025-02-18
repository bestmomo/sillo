<?php
include_once 'basics.php';
?>

<div>
	@section('title', $title = 'Bases de LiveWire')
	<livewire:academy.components.page-title :title=$title />
	
	<h1>Simples exemples</h1>

	<livewire:academy.dpts.frameworks.livewire.hello-world/>
	<livewire:academy.dpts.frameworks.livewire.counter/>

	{{-- <livewire:academy.dpts.frameworks.livewire.counter by=3/> --}}

	<livewire:academy.dpts.frameworks.livewire.Todos/>


</div>

