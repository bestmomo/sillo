<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Livewire;

use App\Models\User;
use Livewire\{Component, WithPagination};

class Uuusers extends Component
{
	use WithPagination;

	public string $search = '';
	// public $users;

	// public function updatingSearch()

	// {
	// 	$this->resetPage();
	// }

	protected $queryString = [
		'search' => ['except' => ''],
	];

	public function paginationView()
	{
		return 'livewire.pagination';
	}

	// public function with()
	// {
	// 	return [
	// 		'users' => User::all(),
	// 	];
	// }

	public function render()
	{
		return view('livewire.uuusers', [
			'users' => User::search($this->search)->paginate(5),
		]);
	}
}
