<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Uuusers extends Component
{
	public $users = [];
	public $count = 0;

	public function mount()
	{
		$this->users = User::all();
	}

	public function incr(): void
	{
		++$this->count;
	}

	public function render()
	{
		return view('livewire.uuusers');
	}
}