<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

 
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.gc7')]
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
