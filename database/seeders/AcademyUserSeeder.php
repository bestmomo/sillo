<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

namespace Database\Seeders;

use App\Models\AcademyUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademyUserSeeder extends Seeder
{
	use WithoutModelEvents;

	// Remise à 0 de l'auto-increment
	// Sqlite: DELETE FROM sqlite_sequence WHERE name = 'messages';
	// MySQL: ALTER TABLE nom_de_la_table AUTO_INCREMENT = 1;

	/**
	 * Reseed que la table academy_users
	 * 
	 * Lancer :
	 * php artisan db:seed --class=AcademyUserSeeder
	 * 
	 */
	public function run()
	{
		AcademyUser::truncate();
		$this->call('Database\\Seeders\\Academy\\AcademyUserSeeder');
	}
}