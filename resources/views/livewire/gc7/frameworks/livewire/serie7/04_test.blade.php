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
	public $subtitle='Infinite Scroll';
	public $amount        = 0;
	public $search        = '';
	public $sortDirection = 'ASC';
	public $sortColumn    = 'id';

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

	public function loadMore()
	{
		$this->amount += 10;
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
 ?>

<div>
    @section('styles')
        <style>
            .drawer-content {
                padding: 0;
            }

            .btn-menu {
                color: #ccc;
                transition: .5s ease-in-out;
            }

            .btn-menu.active {
                font-weight: bold;
                color: orange;
            }

            .btn-menu:hover {
                color: #c7cf2f;
            }
        </style>
    @endsection
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Offset" shadow separator progress-indicator /> --}}
    <x-header class="mt-[-12px] px-0 w-[96%] mx-auto" shadow separator progress-indicator />

    <div class="px-5 mt-[-12px]">
        <div class="py-1 px-3 bg-white dark:bg-gray-800 text-white rounded">
            <p>Test</p>
        </div>
    </div>
