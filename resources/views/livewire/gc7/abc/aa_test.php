<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.gc7.main')]
#[Title('Test')]
class extends Component {
	// public $postId = 7;

	public function mount()
	{
		// $this->name = 'abc';
	}

	public function updatedName()
	{
		// $this->name = strtoupper($this->name);
	}

	public function with()
	{
		return [
			// 'name' => $this->name,
		];
	}
};
