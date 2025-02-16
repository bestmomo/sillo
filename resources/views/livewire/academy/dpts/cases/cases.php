<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.acaLight')]
class extends Component {
	use WithPagination;

	public $subjects         = [];
	public string $search    = '';
	public string $oldSearch = '';
	public $needrefresh      = false;
	protected $queryString   = ['search'];

	public function mount()
	{
		$this->subjects  = $this->subjects();
		$this->oldSearch = $this->search;
		// Debugbar::info($this);
		// $this->resetPage();
		// Debugbar::info($this->lastPage());
	}

	public function updating($name, $value)
	{
		if ('search' === $name) {
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

	public function subjects()
	{
        // 'actual'      => ['Avec le problème de resultats pas visibles', 'tableFilter.actual'],
		$subjects = [
			[
				'state'       => 'Ouvert',
				'title'       => 'Problème de liste après filtrages',
				'description' => 'Tatati...',
				'actual'      => ['Avec le problème de resultats pas visibles','case.table-filter.trouble'],
				'proposed'    => [
					['Avec raffraichissement n°1 (Non adoptable)', 'case.table-filter.soluce1'],
					['Soluce n°2 (À trouver !!!)', 'case.table-filter.soluce2'],
				],
			],
			// [
			// 	'state'       => 'ready',
			// 	'title'       => 'For a next another trouble to solve...',
			// 	'description' => 'John Doe',
			// 	'actual'      => '5yH6y@example.com',
			// 	'proposeds'    => ['5yH6y@example.com'],
			// ],
			// [
			// 	'state'       => 'cloSed',
			// 	'title'       => '(Exemple provisoire) For a trouble resolved.',
			// 	'description' => 'John Doe',
			// 	'actual'      => '5yH6y@example.com',
			// 	'proposeds'    => ['5yH6y@example.com'],
			// ],
		];

		return array_map(fn ($subject) => array_merge($subject, ['stateColor' => $this->setStateColor($subject['state'])]), $subjects);
	}

	private function setStateColor($state)
	{
		return $state=='Ouvert' ? 'error': ($state=='ready' ? 'info' : 'success');
	}
};
