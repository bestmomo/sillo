<?php

/**
 * (ɔ) Sillo-Shop - 2024-2025
 */

use App\Models\Product;
use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component {
	use WithPagination;

	public $search         = '';
	protected $queryString = ['search'];

	public function with(): array
	{
		$items = Product::query()
			->when($this->search, function ($query) {
				$query->where('name', 'like', "%{$this->search}%");
			})
			->paginate(2, ['name']);

		return ['items' => $items];
	}
};
