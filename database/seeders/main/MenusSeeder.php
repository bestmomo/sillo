<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */


/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenusSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		DB::table('menus')->insert([
			['label' => 'Catégorie 1', 'link' => null, 'order' => 3],
			['label' => 'Catégorie 2', 'link' => '/category/category-2', 'order' => 2],
			['label' => 'Catégorie 3', 'link' => '/category/category-3', 'order' => 1],
		]);

		DB::table('submenus')->insert([
			['label' => 'Série 1', 'order' => 1, 'link' => '/serie/serie-1', 'menu_id' => 1],
			['label' => 'Série 2', 'order' => 2, 'link' => '/serie/serie-2', 'menu_id' => 1],
			['label' => 'Tout', 'order' => 3, 'link' => '/category/category-1', 'menu_id' => 1],
		]);
	}
}
