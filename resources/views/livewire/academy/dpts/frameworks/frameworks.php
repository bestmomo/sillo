<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('components.layouts.academy')]
class extends Component{	public $count = 100;
	public $by;

	public function mount($by = 1)
	{
		$this->by = (int) $by;
	}

	public function increment($by = 1)
	{
		$this->count += $by ?? $this->by;
	}

	public function decrement()
	{
		$this->count -= $this->by;
	}};