<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Main;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		// Données des paramètres
		$settings = [
			['key' => 'pagination', 'value' => 6],
			['key' => 'excerptSize', 'value' => 45],
			['key' => 'title', 'value' => 'Laravel'],
			['key' => 'subTitle', 'value' => 'Un framework qui rend heureux'],
			['key' => 'flash', 'value' => ''],
			['key' => 'newPost', 'value' => 4],
			['key' => 'alertValue', 'value' => 'alert-info'],
		];

		// Insérer les données dans la table settings
		DB::table('settings')->insert($settings);
	}
}
