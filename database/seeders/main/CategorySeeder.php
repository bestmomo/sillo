<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
	use WithoutModelEvents;

	public static $nbrCategories;

	public function run()
	{
		$data = [];

		for ($i = 1; $i <= 3; ++$i) {
			$category = "Category {$i}";
			$data[]   = [
				'title' => $category,
				'slug'  => Str::of($category)->slug('-'),
			];
		}

		DB::table('categories')->insert($data);

		self::$nbrCategories = DB::table('categories')->count();
	}
}
