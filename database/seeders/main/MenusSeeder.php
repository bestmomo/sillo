<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace database\seeders\main;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		// Données des menus
		$menus = [
			['label' => 'Catégorie 1', 'link' => null, 'order' => 3],
			['label' => 'Catégorie 2', 'link' => '/category/category-2', 'order' => 2],
			['label' => 'Catégorie 3', 'link' => '/category/category-3', 'order' => 1],
		];

		// Insérer les données dans la table menus
		DB::table('menus')->insert($menus);

		// Données des sous-menus
		$submenus = [
			['label' => 'Série 1', 'order' => 1, 'link' => '/serie/serie-1', 'menu_id' => 1],
			['label' => 'Série 2', 'order' => 2, 'link' => '/serie/serie-2', 'menu_id' => 1],
			['label' => 'Tout', 'order' => 3, 'link' => '/category/category-1', 'menu_id' => 1],
		];

		// Insérer les données dans la table submenus
		DB::table('submenus')->insert($submenus);
	}
}
