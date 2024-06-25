<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class() extends Component {
	use WithPagination;

	public $name;
	public $perPage = 5;
	public $search  = '';

    public $sortDirection = 'ASC';

	public function mount()
	{
		$this->name = 'GC7';
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function with(): array
	{
		return [
			'users' => User::search($this->search)->orderBy('id')
				->paginate($this->perPage),
		];
	}
};