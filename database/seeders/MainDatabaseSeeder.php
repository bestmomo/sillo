<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders;

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
		$namespace = 'Database\\Seeders\\Main\\';
		$items     = ['User', 'Category', 'Serie', 'Post', 'Comment', 'Menus', 'Contact', 'Page', 'Footer', 'Setting', 'Event', 'Survey', 'Quiz'];

		foreach ($items as $item) {
			$seederClass = $namespace . $item . 'Seeder';
			$this->call($seederClass);
		}
	}
}