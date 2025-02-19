<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Test Rapide')]
#[Layout('components.layouts.acaLight')]
class() extends Component
{
	public $activeTests=[];

	public function mount()
	{
		// Dé-commenter cette ligne pour voir les tests
		$this->showTests();
		
		
	}

	public function showTests()
	{
		// $this->activeTests[] = 'stats-users';
		$this->activeTests[] = 'normalize';
	}

	public function with(): mixed
	{
		return [];
	}
};
