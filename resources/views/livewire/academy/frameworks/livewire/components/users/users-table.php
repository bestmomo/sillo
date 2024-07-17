<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class() extends Component {
	use WithPagination;

	public string $search = '';
	public $sortBy        = [
		'column'    => 'id',
		'direction' => 'asc',
	];
	public $queryStringOutput = [];
	protected $queryString    = [
		'search' => ['except' => ''],
		'sortBy' => ['except' => ['column' => 'id', 'direction' => 'asc']],
	];

	// For custom pagination view
	// public function paginationView()
	// {
	// 	return 'livewire.pagination';
	// }
	public function updatedSearch()
	{
		Debugbar::addMessage("New search: {$this->search}");
		$this->queryStringOutput['search'] = $this->search;
		$this->setPage(1);
	}

	public function updatedPage()
	{
		$currentPage = $this->getPage();
		Debugbar::addMessage("New page: {$currentPage}");
		$this->queryStringOutput['page'] = $currentPage;
	}

	public function updatedSortBy($value, $key)
	{
		// dump($this->sortBy['column']);
		// Debugbar::warning($this->sortBy['direction']);

		// To avoid displaying the new sort information twice
		if ('column' === $key || 'direction' === $key) {
			Debugbar::addMessage("New sort: By {$this->sortBy['column']}, {$this->sortBy['direction']}");
			$this->queryStringOutput['sortColumn']    = $this->sortBy['column'];
			$this->queryStringOutput['sortDirection'] = $this->sortBy['direction'];
		} else {
			$this->dispatch('console-log', ['message' => [$value, $key]]);
		}
		// Debugbar::addMessage("New sort: By {$this->sortBy['column']}, {$this->sortBy['direction']}");
	}

	public function setOrderField(string $name)
	{
		if ($name === $this->orderField) {
			$this->orderDirection = 'asc' === $this->orderDirection ? 'desc' : 'ASascC';
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

	public function render():mixed
	{
		$users = User::search($this->search)
			->orderBy(...array_values($this->sortBy))
			->paginate(4);

		$headers = [
			['key' => 'id', 				'label' => '#'],
			['key' => 'name', 			'label' => __('Name')],
			['key' => 'role', 			'label' => __('Role')],
			['key' => 'isStudent', 	'label' => __('Status')],
			['key' => 'valid', 			'label' => __('Valid')],
			['key' => '', 					'label' => ''],
		];

		$roles = [
			'admin' => ['Administrator', 	'error'],
			'redac' => ['Redactor', 			'warning'],
			'user'  => ['User'],
		];

		return view('livewire.uuusers3', [
			'users'   => $users,
			'headers' => $headers,
			'roles'   => $roles,
		]);
	}
};
