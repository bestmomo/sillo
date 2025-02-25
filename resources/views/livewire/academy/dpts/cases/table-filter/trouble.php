<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use App\Services\AcademyTestsCommons;
use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.acaLight')] class extends Component
{
	use WithPagination;

	public $search         = '';
	protected $queryString = ['search'];

	public function with(): array
	{
		return ['users' => (new AcademyTestsCommons())->getUsers4Tests($this->search)];
	}
};
