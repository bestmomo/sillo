<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use App\Models\AcademyUser;
use Livewire\Volt\Component;

new class() extends Component
{
	public $data;

	public function with()
	{
		return [
			'users' => AcademyUser::limit(7)->get('firstname'),
			'var'   => $this->nbUsers(),
			'fake'  => $this->fakesNames(),
		];
	}

	private function nbUsers()
	{
		return AcademyUser::count();
	}

	private function fakesNames()
	{
		return fake()->firstNameFemale();
	}
};
