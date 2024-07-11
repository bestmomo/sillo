<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\User;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Test')]
#[Layout('components.layouts.academy')]
class() extends Component {
	public $roleCounts = [];
	public $studentCounts;
	public $nbrStudents;
	public $nbrUsers;

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
		$result = User::query()
			->selectRaw('role, COUNT(*) as count, SUM(CASE WHEN isStudent = true THEN 1 ELSE 0 END) as student_count')
			->groupBy('role')
			->get();

		$this->roleCounts    = $result->pluck('count', 'role');
		$this->studentCounts = $result->pluck('student_count', 'role');
		$this->nbrUsers      = $result->sum('count');
		$this->nbrStudents   = $result->sum('student_count');
	}
};
