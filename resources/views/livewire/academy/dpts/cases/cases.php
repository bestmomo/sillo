<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.acaLight')]
class extends Component
{
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

	public function subjects()
	{
		// 'actual'      => ['Avec le problème de resultats pas visibles', 'tableFilter.actual'],
		$subjects = [
			[
				'state'       => 'Ouvert',
				'title'       => 'Problème de liste après filtrages',
				'description' => '<i>Voir situation actuelle pour découvrir le contexte</i>',
				'actual'      => ['Avec le problème de resultats existants mais non visibles', 'academy.case.table-filter.trouble'],
				'proposed'    => [
					['Avec raffraichissement n°1 (Non adoptable...)', 'academy.case.table-filter.soluce1'],
					['Soluce n°2 (À trouver !!!)', 'academy.case.table-filter.soluce2'],
				],
			],
			[
				'state'       => 'ready',
				'title'       => 'For a next another trouble to solve...',
				'description' => '<p class="text-orange-500 italic">PAS DE BADGE COLORÉ, car le statut READY n\'existe pas \'en vrai\'</p>',
				'actual'      => ['5yH6y@example.com', 'academy.case.table-filter.trouble'],
				'proposed'    => [
					['Juste pour un exemple...', 'academy.case.table-filter.soluce1'],
					['Juste pour un second exemple...', 'academy.case.table-filter.soluce2'],
				],
			],
			[
				'state'       => 'ferMé',
				'title'       => '(Exemple provisoire) For a trouble resolved.',
				'description' => 'John Doe',
				'actual'      => ['5yH6y@example.com', 'academy.case.table-filter.trouble'],
				'proposed'    => [
					['Juste pour un exemple...', 'academy.case.table-filter.soluce1'],
				],
			],
		];

		return array_map(fn ($subject) => array_merge($subject, ['stateColor' => $this->setStateColor($subject['state'])]), $subjects);
	}

	private function setStateColor($state)
	{
		return 'Ouvert' == $state ? 'error' : ('ready' == $state ? 'info' : 'success');
	}
};