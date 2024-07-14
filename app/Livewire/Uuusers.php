<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Uuusers extends Component
{
	public string $search = '';
	// public $users;

	// public function updatingSearch()
	// {
	// 	$this->resetPage();
	// }

	public function with()
	{
		return [
			'users' => User::all(),
		];
	}

	public function render()
	{
		return view('livewire.uuusers', [
			'users' => User::search($this->search)->get(),
		]);
	}
}