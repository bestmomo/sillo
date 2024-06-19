<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Services\Gc7FrameworksLinksService;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

new
#[Layout('components.layouts.gc7.main')]
#[Title('Test')]
class extends Component {
	public $links = [];

	public function mount(): void
	{
		$this->links = app(Gc7FrameworksLinksService::class)->getLinks();

		$paths = $this->getPathsRoutes();
		
		$this->createSitemap();
		
		

		// dd($this->links);
	}

	public function createSitemap()
	{
		$routeCollection = Route::getRoutes();

		$sitemap = Sitemap::create();

		foreach ($routeCollection as $route) {
			$sitemap->add(Url::create($route->uri()));
		}

		$sitemap->writeToFile(public_path('complete_sitemap.xml'));
	}

	public function getPathsRoutes()
	{
		$routeCollection = Route::getRoutes();

		$paths = [];

		foreach ($routeCollection as $route) {
			// $paths[] = $route->getPath();
		}

		return $paths;
	}
};
