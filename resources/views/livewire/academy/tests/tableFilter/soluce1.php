<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

use App\Models\Product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Pagination\{Paginator};
use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component {
	use WithPagination;

	public $search           = '';
	public string $oldSearch = '';
	public $needrefresh      = false;
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

	public function with(): array
	{
		$items = Product::query()
			->when($this->search, function ($query) {
				$query->where('name', 'like', "%{$this->search}%");
			})
			->paginate(2, ['name']);
		// $items = $products['items']->getCollection();
		// $items = $products['items'];

		$lastPg = $items->lastPage();
		$currPg = $items->currentPage();
		Debugbar::addMessage($currPg, 'currPg');
		Debugbar::addMessage($lastPg, 'lastPg');

		if ($lastPg < $currPg) {
			Debugbar::addMessage('yes');
			$items->needRefresh = true;
			redirect()->route('tableFilter.soluce1', ['page' => $lastPg, 'search' => $this->search]);
		}
		// Debugbar::addMessage($items);

		// Debugbar::warning($items);

		// $arr = $items->toArray();
		// // $items = new Paginator($arr, 3, 3);
		// $products['items'] = collect($arr)->paginate(3);
		// // $items = collect($arr)->paginate(3);
		// $items->setPage(2);
		// $this->resetPage();
		return ['items' => $items];
	}
};