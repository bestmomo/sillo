<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders;

use App\Models\{AcademyPost, AcademyUser};
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademyDatabaseSeeder extends Seeder
{
	use WithoutModelEvents;

	// Remise à 0 de l'auto-increment
	// Sqlite: DELETE FROM sqlite_sequence WHERE name = 'messages';
	// MySQL: ALTER TABLE nom_de_la_table AUTO_INCREMENT = 1;

	/**
	 * Seed the academy application's database.
	 */
	public function run()
	{
		// Academy Users

		$start = Carbon::now()->subYears(2);  // Il y a 2 ans
		$end   = Carbon::now()->subYear();      // Il y a 1 an
		AcademyUser::factory()->count(777)->create([
			'created_at' => generateRandomDateInRange($start, $end),
		]);

		$unValidUser            = AcademyUser::find(4);
		$unValidUser->isStudent = true;
		$unValidUser->valid     = false;
		$unValidUser->save();

		AcademyPost::factory()->count(9)->create();
	}
}
