<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	use WithoutModelEvents;

	/**
	 * Seed the application's database.
	 */
	public function run()
	{
		$this->call([
			MainDatabaseSeeder::class,
			AcademyDatabaseSeeder::class,
		]);

		// REPORT
		printf('%s%s', str_repeat(' ', 2), "Data tables properly filled.\n\n");
	}
}
