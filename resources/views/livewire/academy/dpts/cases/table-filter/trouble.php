<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use App\Models\AcademyUser;
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
		$users = AcademyUser::query()
			->where('id', '!=', 1)
			->when($this->search, function ($query)
			{
				$query->where('firstname', 'like', "%{$this->search}%");
			})
			->paginate(3, ['firstname']);

		return ['users' => $users];
	}
};