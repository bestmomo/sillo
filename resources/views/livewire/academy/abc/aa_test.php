<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use App\Models\AcademyUser;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Test')]
#[Layout('components.layouts.academy')]
class() extends Component {
	public $roleCounts = [];
	public $studentCounts;
	public $studentsCount;
	public $usersCount;

	public function mount()
	{
		$this->usersStat();
	}

	public function with(): mixed
	{
		return [];
	}

	protected function usersStat()
	{
		$result = AcademyUser::query()
			->selectRaw('role, COUNT(*) as count, SUM(CASE WHEN academyAccess = true THEN 1 ELSE 0 END) as academy_users')
			->groupBy('role')
			->get();

		$this->roleCounts    = $result->pluck('count', 'role');
		$this->studentCounts = $result->pluck('academy_users', 'role');
		$this->usersCount    = $result->sum('count');
		$this->studentsCount = $result->sum('academy_users');
	}
};
