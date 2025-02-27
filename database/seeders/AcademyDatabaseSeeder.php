<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

namespace Database\Seeders;

use App\Models\AcademyPost;
use App\Models\AcademyUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

		foreach ($items as $item)
		{
			$seederClass = "{$namespace}Academy{$item}Seeder";
			$this->call($seederClass);
		}
	}
}
