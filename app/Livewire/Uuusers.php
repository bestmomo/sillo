<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Uuusers extends Component
{
	public $count = 0;

	public function incr(): void
	{
		++$this->count;
	}

	public function render()
	{
		return view('livewire.uuusers', [
			'users' => User::all(),
		]);
	}
}
