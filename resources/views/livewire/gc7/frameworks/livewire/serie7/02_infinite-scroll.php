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
	public $amount        = 0;
	public $search        = '';
	public $sortDirection = 'ASC';
	public $sortColumn    = 'id';

	public function mount()
	{
		$this->name = 'GC7';
	}

	public function doSort($column)
	{
		$this->sortColumn = $column;
		if ($this->sortColumn === $column) {
			$this->sortDirection = 'ASC' == $this->sortDirection ? 'DESC' : 'ASC';

			return;
		}
		$this->sortColumn    = $column;
		$this->sortDirection = 'ASC';
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function loadMore()
	{
		$this->amount += 100;
	}

	public function with(): array
	{
		$users = User::take($this->amount)
			->search($this->search)
			->orderBy($this->sortColumn, $this->sortDirection)
			->get();

		return [
			'users' => $users,
		];
	}
};
