<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Providers;

use App\Models\{Menu, Setting};
use App\Services\AcademyFrameworksLinksService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\{Facades, ServiceProvider};
use Illuminate\View\View;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->singleton(AcademyFrameworksLinksService::class, function () {
			return new AcademyFrameworksLinksService();
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
