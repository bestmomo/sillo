<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders;

use Database\Seeders\Main\{CategorySeeder, CommentSeeder, ContactSeeder, EventSeeder, FooterSeeder, MenusSeeder, PageSeeder, PostSeeder, QuizSeeder, SerieSeeder, SettingSeeder, SurveySeeder, UserSeeder};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainDatabaseSeeder extends Seeder
{
	use WithoutModelEvents;

	/**
	 * Seed the main application's database.
	 */
	public function run()
	{
		$this->call([
			UserSeeder::class,
			CategorySeeder::class,
			SerieSeeder::class,
			PostSeeder::class,
			CommentSeeder::class,
			MenusSeeder::class,
			ContactSeeder::class,
			PageSeeder::class,
			FooterSeeder::class,
			SettingSeeder::class,
			EventSeeder::class,
			SurveySeeder::class,
			QuizSeeder::class,
		]);
	}
}