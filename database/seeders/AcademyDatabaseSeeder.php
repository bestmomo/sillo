<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders;

use Database\Seeders\Academy\{AcademyPostSeeder, AcademyUserSeeder};
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
		$this->call([
			AcademyUserSeeder::class,
			AcademyPostSeeder::class,
		]);
	}
}