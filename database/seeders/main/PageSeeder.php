<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace database\seeders\main;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		// Données des pages
		$items = [
			['slug' => 'terms', 'title' => 'Terms'],
			['slug' => 'privacy-policy', 'title' => 'Privacy Policy'],
		];

		foreach ($items as $item) {
			Page::factory()->create([
				'title'     => $item['title'],
				'seo_title' => 'Page ' . $item['title'],
				'slug'      => $item['slug'],
			]);
		}
	}
}
