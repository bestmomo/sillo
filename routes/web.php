<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Volt\Volt;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdminOrRedac;
use App\Http\Controllers\ImageController;

// Routes publiques
Volt::route('/', 'index');

Volt::route('/t', 'gc7.abc.aaa_test');

Volt::route('/frameworks', 'gc7.frameworks');
Route::prefix('/framework')->group(function () {
	getGc7FrameworksRoutes();
});

Route::post('/upload-image', [ImageController::class, 'upload']);

Volt::route('/contact', 'contact')->name('contact');
Volt::route('/category/{slug}', 'index');
Volt::route('/serie/{slug}', 'index');
Volt::route('/search/{param}', 'index')->name('posts.search');

Volt::route('/posts/{slug}', 'posts.show')->name('posts.show');
Volt::route('/pages/{page:slug}', 'pages.show')->name('pages.show');

// Routes pour les invités
Route::middleware('guest')->group(function () {
	Volt::route('/login', 'auth.login')->name('login');
	Volt::route('/register', 'auth.register');
	Volt::route('/forgot-password', 'auth.forgot-password');
	Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

// Routes pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
	Volt::route('/profile', 'auth.profile')->name('profile');
	Volt::route('/chat', 'chat')->name('chat');

	// Routes pour les administrateurs et rédacteurs
	Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
		Volt::route('/dashboard', 'admin.index')->name('admin');
		Volt::route('/posts/index', 'admin.posts.index')->name('posts.index');
		Volt::route('/posts/create', 'admin.posts.create')->name('posts.create');
		Volt::route('/posts/{post:slug}/edit', 'admin.posts.edit')->name('posts.edit');
		Volt::route('/series/index', 'admin.series.index')->name('series.index');
		Volt::route('/series/{serie}/edit', 'admin.series.edit')->name('series.edit');

		// Routes uniquement pour les administrateurs
		Route::middleware(IsAdmin::class)->group(function () {
			Volt::route('/categories/index', 'admin.categories.index')->name('categories.index');
			Volt::route('/categories/{category}/edit', 'admin.categories.edit')->name('categories.edit');
			Volt::route('/pages/index', 'admin.pages.index')->name('pages.index');
			Volt::route('/pages/create', 'admin.pages.create')->name('pages.create');
			Volt::route('/pages/{page:slug}/edit', 'admin.pages.edit')->name('pages.edit');
			Volt::route('/users/index', 'admin.users.index')->name('users.index');
			Volt::route('/users/{user}/edit', 'admin.users.edit')->name('users.edit');
			Volt::route('/menus/index', 'admin.menus.index')->name('menus.index');
			Volt::route('/menus/{menu}/edit', 'admin.menus.edit')->name('menus.edit');
			Volt::route('/footers/index', 'admin.menus.footers')->name('menus.footers');
			Volt::route('/footers/{footer}/edit', 'admin.menus.editfooter')->name('footers.edit');
			Volt::route('/submenus/{submenu}/edit', 'admin.menus.editsub')->name('submenus.edit');
			Volt::route('/contacts/index', 'admin.contacts.index')->name('contacts.index');
			Volt::route('/images/index', 'admin.images.index')->name('images.index');
			Volt::route('/images/{year}/{month}/{id}/edit', 'admin.images.edit')->name('images.edit');
			Volt::route('/settings', 'admin.settings')->name('settings');
		});

		// Routes pour les commentaires
		Volt::route('/comments/index', 'admin.comments.index')->name('comments.index');
		Volt::route('/comments/{comment}/edit', 'admin.comments.edit')->name('comments.edit');
	});
});
