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

	public string $search         = '';
	public string $orderField     = 'name';
	public string $orderDirection = 'ASC';

	// public $users;

	// public function updatingSearch()

	// {
	// 	$this->resetPage();
	// }

	protected $queryString = [
		'search' => ['except' => ''],
	];

	// public function paginationView()
	// {
	// 	return 'livewire.pagination';
	// }

	public function setOrderField(string $name)
	{
		if ($name === $this->orderField) {
			$this->orderDirection = 'ASC' === $this->orderDirection ? 'DESC' : 'ASC';
		} else {
			$this->orderField = $name;
			$this->reset('orderDirection');
		}
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
			'users' => User::search($this->search)
				->orderBy($this->orderField, $this->orderDirection)
				->paginate(5),
		]);
	}
}