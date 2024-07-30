<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders;

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
		$namespace = 'Database\\Seeders\\Academy\\';
		$items     = ['User', 'Post'];

		foreach ($items as $item) {
			$seederClass = "{$namespace}Academy{$item}Seeder";
			$this->call($seederClass);
		}
	}
}
