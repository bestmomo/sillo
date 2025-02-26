<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use App\Models\AcademyUser;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout};
use App\Services\AcademyTestsCommons;
use Illuminate\Pagination\{Paginator};
use Barryvdh\Debugbar\Facades\Debugbar;

new #[Layout('components.layouts.acaLight')] class extends Component
{
	use WithPagination;

	public $search           = '';
	public string $oldSearch = '';
	public $needRefresh      = false;
	protected $queryString   = ['search'];

	public function mount()
	{
		$this->oldSearch = $this->search;
		// Debugbar::info($this);
		// $this->resetPage();
		// Debugbar::info($this->lastPage());
	}

	public function updating($name, $value)
	{
		if ('search' === $name)
		{
			$this->oldSearch = $this->search;
			// $this->resetPage();
			Debugbar::info('Ancienne valeur: ' . $this->search);
			Debugbar::info('Updating...');
		}
	}

	public function updatedSearch($value)
	{
		Debugbar::info('Nouvelle valeur: ' . $value);

		Debugbar::info('Updated !');
	}

	public function with(): array
	{
		$users = (new AcademyTestsCommons())->getUsers4Tests($this->search);

		// $items = $products['items']->getCollection();
		// $items = $products['items'];

		$lastPg = $users->lastPage();
		$currPg = $users->currentPage();
		Debugbar::addMessage($currPg, 'currPg');
		Debugbar::addMessage($lastPg, 'lastPg');

		if ($lastPg < $currPg)
		{
			Debugbar::addMessage('yes');
			$users->needRefresh = true;
			redirect()->route('academy.case.table-filter.soluce1', ['page' => $lastPg, 'search' => $this->search]);
		}
		return ['users' => $users];
	}
};
