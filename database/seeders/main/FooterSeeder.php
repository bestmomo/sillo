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

class FooterSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		// Footer
		DB::table('footers')->insert([
			['label' => 'Accueil', 'order' => 1, 'link' => '/'],
			['label' => 'Terms', 'order' => 3, 'link' => '/pages/terms'],
			['label' => 'Policy', 'order' => 4, 'link' => '/pages/privacy-policy'],
			['label' => 'Contact', 'order' => 5, 'link' => '/contact'],
		]);
	}
}
