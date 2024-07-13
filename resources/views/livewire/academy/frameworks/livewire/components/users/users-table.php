<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\User;
use Livewire\Volt\Component;

new class() extends Component {
	public $count = 0;
	public $users = [];

	public function incr(): void
	{
		++$this->count;
	}

	public function mount()
	{
		// $this->users = User::limit(10)->get();
		$this->users = User::all();
	}

};