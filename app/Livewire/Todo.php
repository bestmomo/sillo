<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Livewire;

use Livewire\Component;

class Todo extends Component
{
	public $todo  = '';
	public $todos = ['Take out trash', 'Do dishes'];

	public function add()
	{
		$this->todos[] = $this->todo;
		$this->todo    = '';
	}

	public function render()
	{
		return view('livewire.todo');
	}
}
