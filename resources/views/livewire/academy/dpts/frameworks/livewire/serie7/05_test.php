<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Livewire\Volt\Component;

new class() extends Component
{
	public $subtitle = 'Test';

	public function mount($loadMore = true, $offset = 0)
	{
		$this->dispatch('update-subtitle', newSubtitle: $this->subtitle);
		logger('Dispatching update-subtitle event');
	}

	public function with(): array
	{
		return [
		];
	}
};