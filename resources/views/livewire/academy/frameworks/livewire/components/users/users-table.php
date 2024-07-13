<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\User;
use Livewire\Volt\Component;

new class() extends Component {
	public $users = [];

	public function mount()
	{
		$this->users = User::all();
	}
};
