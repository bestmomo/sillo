<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Livewire\Attributes\{Layout, Title};
use Livewire\Livewire;
use Livewire\Volt\Component;

new
#[Title('Test Rapide')]
#[Layout('components.layouts.acaLight')]
class() extends Component
{
	public $activeTests = [];

	public function mount()
	{
		// Dé-commenter cette ligne pour voir les tests
		$this->showTests();
	}

	public function showTests()
	{
		$activeTests = [];

		// Ou choisir vos tests parmis ci-dessous: 
		
		// $activeTests[] = 'ready';
		// $activeTests[] = 'stats-users';
		// $activeTests[] = 'aca-users';

		// $this->renderTestsHtml($activeTests);
		$this->activeTests = $activeTests;
	}

	public function renderTestsHtml($tests = [])
	{
		/*
			@if (in_array('stats-users', $activeTests))
				@livewire('academy.dpts.tests.stats-users', ['testsNames' => $activeTests])
	@endif
			@if (in_array('ready', $activeTests))
				@livewire('academy.dpts.tests.ready')
	@endif
		@if (in_array('aca-users', $activeTests))
		@livewire('academy.dpts.tests.aca-users', ['testsNames' => $activeTests])
	@endif --}}
		 */
	}

	// public function with(): mixed
	// {
	// 	return [];
	// }
};
