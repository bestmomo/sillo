<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Academy;

use App\Models\AcademyUser;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademyUserSeeder extends Seeder {
	use WithoutModelEvents;

	public function run() {
		$start = Carbon::now()->subYears(2);  // Il y a 2 ans
		$end   = Carbon::now()->subYear();    // Il y a 1 an
		AcademyUser::factory()->count(777)->create([
			'created_at' => generateRandomDateInRange($start, $end),
		]);

		$unValidUser        = AcademyUser::find(4);
		$unValidUser->valid = false;
		$unValidUser->save();
	}
}
