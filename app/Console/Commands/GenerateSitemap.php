<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sitemap:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate sitemap';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		// Manually create sitemap
		$sitemap = Sitemap::create();

		// Home page
		$sitemap->add('/');

		// Static pages
		$pages = Page::select('slug')->get();
		foreach ($pages as $page) {
			$sitemap->add("/posts/{$page->slug}");
		}

		// Dynamic pages
		$posts = Post::select('slug')->whereActive(true)->get();
		foreach ($posts as $post) {
			$sitemap->add("/posts/{$post->slug}");
		}

		$sitemap->writeToFile(public_path('sitemap.xml'));
	}
}
