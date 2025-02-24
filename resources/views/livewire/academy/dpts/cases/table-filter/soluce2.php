<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout};
use App\Services\AcademyTestsCommons;
use Barryvdh\Debugbar\Facades\Debugbar;

new #[Layout('components.layouts.acaLight')] class extends Component
{
	use WithPagination;

	public $search           = '';
	public string $oldSearch = '';
	public $needrefresh      = false;
	protected $queryString   = ['search'];

	public function mount()
	{
		$this->oldSearch = $this->search;
	}

	public function updating($name, $value)
	{
		if ('search' === $name)
		{
			$this->oldSearch = $this->search;
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
		return ['users' => (new AcademyTestsCommons())->getUsers4Tests($this->search)];
	}
};
