<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;

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
		User::factory()->create([
			'name'       => 'Admin',
			'email'      => 'admin@example.com',
			'role'       => 'admin',
			'isStudent'  => true,
			'created_at' => Carbon::now()->subYears(3),
			'updated_at' => Carbon::now()->subYears(3),
		]);

		User::factory()->create([
			'name'       => 'Redac',
			'role'       => 'redac',
			'email'      => 'redac@example.com',
			'created_at' => Carbon::now()->subYears(3),
			'updated_at' => Carbon::now()->subYears(3),
		]);

		User::factory()->create([
			'name'       => 'User',
			'role'       => 'user',
			'email'      => 'user@example.com',
			'created_at' => Carbon::now()->subYears(3),
			'updated_at' => Carbon::now()->subYears(3),
		]);

		// Create 1 redactor
		User::factory()->count(1)->create([
			'role'       => 'redac',
			'created_at' => generateRandomDateInRange('2022-01-01', '2024-01-01'),
		]);

		// Create 3 users
		User::factory()->count(3)->create([
			'created_at' => generateRandomDateInRange('2022-01-01', '2024-01-01'),
		]);

		$unValidUser            = User::find(4);
		$unValidUser->isStudent = true;
		$unValidUser->valid     = false;
		$unValidUser->save();

		self::$nbrUsers = User::count();
	}
}
