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
	public $subtitle = 'Test';
	public $limit    = 5;
	public $offset   = 0;
	public $users;
	public $loadMore;

	public function mount($loadMore = true, $offset = 0)
	{
		$this->name = 'GC7';
		
		// $this->dispatch('update-subtitle', newSubtitle: $this->subtitle);
		logger('Dispatching update-subtitle event');

		$this->loadMore = $loadMore;
		$this->offset   = $offset;
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function with(): array
	{
		if ($this->loadMore) {
			$this->users = User::offset($this->offset)
				->limit($this->limit)
				->get();
		}
		
		echo '<div class="p-5">Nb' . count($this->users).'</div>';
		// exit;

		return [
			'users' => $this->users,
		];
	}
};
