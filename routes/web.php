<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use App\Http\Controllers\ImageController;
use App\Http\Middleware\{IsAdmin, IsAdminOrRedac, IsStudent};
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Routes publiques
Volt::route('/', 'index');

// Volt::route('/doc', 'doc.memo')->name('doc.memo');

Volt::route('/academy', 'academy.academy')->name('academy.academy');
Volt::route('/t', 'academy.abc.aaa_test')->name('academy.test');
Volt::route('/frameworks', 'academy.frameworks');
Route::prefix('/framework')->group(function () {
	getAcademyFrameworksRoutes();
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
	Route::middleware(IsStudent::class)->group(function () {
		Volt::route('/framework/alpinejs/chats', 'academy.frameworks.alpinejs.chats')->name('alpinejs.chats');
	});

	Volt::route('/profile', 'auth.profile')->name('profile');
	Volt::route('/favorites', 'index')->name('posts.favorites');
	Volt::route('/chat', 'chat')->name('chat');
	Volt::route('/quizzes/{id}', 'quizzes.show')->name('quizzes.show');
	Volt::route('/surveys/doing/{id}', 'surveys.doing')->name('surveys.doing');
	Volt::route('/surveys/show/{id}', 'surveys.show')->name('surveys.show');

	// Routes pour les administrateurs et rédacteurs
	Route::middleware(IsAdminOrRedac::class)
		->prefix('admin')
		->group(function () {
			Volt::route('/dashboard', 'admin.index')->name('admin');
			Volt::route('/posts/index', 'admin.posts.index')->name('posts.index');
			Volt::route('/posts/create', 'admin.posts.create')->name('posts.create');
			Volt::route('/posts/{post:slug}/edit', 'admin.posts.edit')->name('posts.edit');
			Volt::route('/series/index', 'admin.series.index')->name('series.index');
			Volt::route('/series/{serie}/edit', 'admin.series.edit')->name('series.edit');
			Volt::route('/quizzes/index', 'admin.quizzes.index')->name('quizzes.index');
			Volt::route('/quizzes/create', 'admin.quizzes.create')->name('quizzes.create');
			Volt::route('/quizzes/{quiz}/edit', 'admin.quizzes.edit')->name('quizzes.edit');
			Volt::route('/surveys/index', 'admin.surveys.index')->name('surveys.index');
			Volt::route('/surveys/create', 'admin.surveys.create')->name('surveys.create');
			Volt::route('/surveys/{survey}/edit', 'admin.surveys.edit')->name('surveys.edit');

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
				Volt::route('/events/index', 'admin.events.index')->name('events.index');
				Volt::route('/events/create', 'admin.events.create')->name('events.create');
				Volt::route('/events/{event}/edit', 'admin.events.edit')->name('events.edit');
			});

			// Routes pour les commentaires
			Volt::route('/comments/index', 'admin.comments.index')->name('comments.index');
			Volt::route('/comments/{comment}/edit', 'admin.comments.edit')->name('comments.edit');
		});
});

Route::fallback(function () {
	$path         = request()->path();
	$redirectPath = '/posts/' . $path;

	return redirect(url($redirectPath));
});

//2see : Develop a component for all topics in 'LaDOC', and group the related routes
// À faire : Développer un composant pour toutes les thématiques de 'LaDOC', et regrouper les routes correspondantes
Route::get('/doc/laravel', function () {
	return view('docs.laravel');
})->name('docs.laravel');

Route::get('/doc/ladoc', function () {
	return view('docs.ladoc');
})->name('docs.ladoc');

