<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Livewire;

use App\Models\User;
use Livewire\{Component, WithPagination};

class Uuusers3 extends Component
{
	use WithPagination;

	public string $search  = '';
	public $sortBy         = ['column' => 'id', 'direction' => 'asc'];
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
		$users = User::search($this->search)
			->orderBy(...array_values($this->sortBy))
			->paginate(4);

		$headers = [
			['key' => 'id', 			 'label' => '#'],
			['key' => 'name', 		 'label' => __('Name')],
			['key' => 'role', 		 'label' => __('Role')],
			['key' => 'isStudent', 'label' => __('Status')],
			['key' => 'valid', 		 'label' => __('Valid')],
			['key' => '', 				 'label' => ''],
		];

		$roles = [
			'admin' => ['Administrator', 'error'],
			'redac' => ['Redactor', 'warning'],
			'user'  => ['User'],
		];

		return view('livewire.uuusers3', [
			'users'     => $users,
			'headers'   => $headers,
			'roles' => $roles,
		]);
	}
}
