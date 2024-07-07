<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\Gc7FrameworksLinksService;

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
		\Illuminate\Support\Facades\View::composer(['components.layouts.app'], function (View $view) {
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
