<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */


/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		DB::table('settings')->insert([
			['key' => 'pagination', 'value' => 6],
			['key' => 'excerptSize', 'value' => 45],
			['key' => 'title', 'value' => 'Laravel'],
			['key' => 'subTitle', 'value' => 'Un framework qui rend heureux'],
			['key' => 'flash', 'value' => ''],
			['key' => 'newPost', 'value' => 4],
		]);
	}
}
