<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	use WithoutModelEvents;

	// Remise à 0 de l'auto-increment
	// Sqlite: DELETE FROM sqlite_sequence WHERE name = 'messages';
	// MySQL: ALTER TABLE nom_de_la_table AUTO_INCREMENT = 1;

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
