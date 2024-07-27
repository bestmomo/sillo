<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		$items = [
			['terms', 'Terms'],
			['privacy-policy', 'Privacy Policy'],
		];

		foreach ($items as $item) {
			Page::factory()->create([
				'title'     => $item[1],
				'seo_title' => 'Page ' . $item[1],
				'slug'      => $item[0],
			]);
		}
	}
}
