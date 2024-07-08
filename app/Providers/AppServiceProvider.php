<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Providers;

use App\Models\{Menu, Setting};
use App\Services\Gc7FrameworksLinksService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\{Facades, ServiceProvider};
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->singleton(Gc7FrameworksLinksService::class, function () {
			return new Gc7FrameworksLinksService();
		});
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Facades\View::composer(['components.layouts.app'], function (View $view) {
			$view->with(
				'menus',
				Menu::with(['submenus' => function ($query) {
					$query->orderBy('order');
				}])->orderBy('order')->get()
			);
		});

		// Vérifiez si la table 'settings' existe
		if (!$this->app->runningInConsole() && Schema::hasTable('settings')) {
			$settings = Setting::all();
			foreach ($settings as $setting) {
				config(['app.' . $setting->key => $setting->value]);
			}
		}
	}
}
