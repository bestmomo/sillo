<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SerieSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		DB::table('series')->insert([
			[
				'title'       => 'Serie 1',
				'slug'        => Str::of('Serie 1')->slug('-'),
				'category_id' => 1,
				'user_id'     => 1,
			],
			[
				'title'       => 'Serie 2',
				'slug'        => Str::of('Serie 2')->slug('-'),
				'category_id' => 1,
				'user_id'     => 1,
			],
		]);
	}
}
