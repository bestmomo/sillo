<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new // #[Title('Serie7')]
// #[Layout('components.layouts.academy')]
class() extends Component {
	use WithPagination;

	public $subtitle = 'Users';
	public $name;
	public $perPage       = 5;
	public $search        = 'min';
	public $sortDirection = 'ASC';
	public $sortColumn    = 'name';

	public function mount()
	{
		$this->name = 'GC7';

		$this->dispatch('update-subtitle', newSubtitle: $this->subtitle);
		logger('Dispatching update-subtitle event');
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

	public function with(): array
	{
		$paginator = User::search($this->search)
			->orderBy($this->sortColumn, $this->sortDirection)
			->paginate($this->perPage);

		return [
			'users'     => $paginator,
			'paginator' => [
				'current' => $paginator->currentPage(),
				'last'    => $paginator->lastPage(),
			],
		];
	}
};
