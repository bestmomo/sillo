<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Main;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	use WithoutModelEvents;

	public static $nbrUsers;

	public function run()
	{
		// Données des utilisateurs
		$users = [
			[
				'name'       => 'Admin',
				'email'      => 'admin@example.com',
				'role'       => 'admin',
				'isStudent'  => true,
				'created_at' => Carbon::now()->subYears(3),
				'updated_at' => Carbon::now()->subYears(3),
			],
			[
				'name'       => 'Redac',
				'email'      => 'redac@example.com',
				'role'       => 'redac',
				'created_at' => Carbon::now()->subYears(3),
				'updated_at' => Carbon::now()->subYears(3),
			],
			[
				'name'       => 'User',
				'email'      => 'user@example.com',
				'role'       => 'user',
				'created_at' => Carbon::now()->subYears(3),
				'updated_at' => Carbon::now()->subYears(3),
			],
		];

		// Créer les utilisateurs spécifiques
		foreach ($users as $userData)
		{
			User::factory()->create($userData);
		}

		// Créer un rédacteur supplémentaire
		User::factory()->count(1)->create([
			'role'       => 'redac',
			'created_at' => generateRandomDateInRange('2022-01-01', '2024-01-01'),
		]);

		// Créer trois utilisateurs supplémentaires
		User::factory()->count(3)->create([
			'created_at' => generateRandomDateInRange('2022-01-01', '2024-01-01'),
		]);

		// Mettre à jour un utilisateur spécifique
		$unValidUser = User::find(4);
		if ($unValidUser)
		{
			$unValidUser->isStudent = true;
			$unValidUser->valid     = false;
			$unValidUser->save();
		}

		// Mettre à jour le nombre d'utilisateurs
		self::$nbrUsers = User::count();
	}
}
