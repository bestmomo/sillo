<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Seeders;

use App\Models\{Comment, Contact, Event, Page, Post, User};
use Carbon\Carbon;
use Database\Seeders\Main\{QuizSeeder, SurveySeeder};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainDatabaseSeeder extends Seeder
{
	use WithoutModelEvents;

	/**
	 * Seed the application's database.
	 */
	public function run()
	{
		// Users

		// Create 2 admins
		User::factory()->create([
			'name'       => 'Admin',
			'email'      => 'admin@example.com',
			'role'       => 'admin',
			'isStudent'  => true,
			'created_at' => Carbon::now()->subYears(3),
			'updated_at' => Carbon::now()->subYears(3),
		]);

		User::factory()->create([
			'name'       => 'Redac',
			'role'       => 'redac',
			'email'      => 'redac@example.com',
			'created_at' => Carbon::now()->subYears(3),
			'updated_at' => Carbon::now()->subYears(3),
		]);

		User::factory()->create([
			'name'       => 'User',
			'role'       => 'user',
			'email'      => 'user@example.com',
			'created_at' => Carbon::now()->subYears(3),
			'updated_at' => Carbon::now()->subYears(3),
		]);

		// Create 1 redactor
		User::factory()->count(1)->create([
			'role'       => 'redac',
			'created_at' => generateRandomDateInRange('2022-01-01', '2024-01-01'),
		]);

		// Create 3 users
		User::factory()->count(3)->create([
			'created_at' => generateRandomDateInRange('2022-01-01', '2024-01-01'),
		]);

		$unValidUser            = User::find(4);
		$unValidUser->isStudent = true;
		$unValidUser->valid     = false;
		$unValidUser->save();

		$nbrUsers = User::all()->count();

		// Categories
		DB::table('categories')->insert([
			[
				'title' => 'Category 1',
				'slug'  => Str::of('Category 1')->slug('-'),
			],
			[
				'title' => 'Category 2',
				'slug'  => Str::of('Category 2')->slug('-'),
			],
			[
				'title' => 'Category 3',
				'slug'  => Str::of('Category 3')->slug('-'),
			],
		]);

		$nbrCategories = 3;

		// Series
		DB::table('series')->insert([
			[
				'title'       => 'Serie 1',
				'slug'        => Str::of('Serie 1')->slug('-'),
				'category_id' => 1,
				'user_id'     => 1,
			],
			[
				'title'       => 'Serie 2',
				'slug'        => Str::of('Serie 2')->slug('-'),
				'category_id' => 1,
				'user_id'     => 1,
			],
		]);

		$nbrSeries = 2;

		$this->createPost(1, 1, 1);
		$this->createPost(2, rand(1, $nbrCategories));
		$this->createPost(3, 1, 1, 1);
		$this->createPost(4, 1, 1, 3);
		$this->createPost(5, rand(1, $nbrCategories));
		$this->createPost(6, 1, 2);
		$this->createPost(7, 1, 2, 6);
		$this->createPost(8, rand(1, $nbrCategories));
		$this->createPost(9, rand(1, $nbrCategories));

		$nbrPosts = 9;

		// Comments
		foreach (range(1, $nbrPosts - 1) as $i) {
			$this->createComment($i, rand(1, $nbrUsers));
		}

		$comment = $this->createComment(2, 3);
		$this->createComment(2, 4, $comment->id);

		$comment = $this->createComment(2, 6);
		$this->createComment(2, 3, $comment->id);

		$comment = $this->createComment(2, 6, $comment->id);

		$comment = $this->createComment(2, 3, $comment->id);
		$this->createComment(2, 6, $comment->id);

		$comment = $this->createComment(4, 4);

		$comment = $this->createComment(4, 5, $comment->id);
		$this->createComment(4, 2, $comment->id);
		$this->createComment(4, 1, $comment->id);

		// Menus
		DB::table('menus')->insert([
			['label' => 'Catégorie 1', 'link' => null, 'order' => 3],
			['label' => 'Catégorie 2', 'link' => '/category/category-2', 'order' => 2],
			['label' => 'Catégorie 3', 'link' => '/category/category-3', 'order' => 1],
		]);

		// Sous-menus
		DB::table('submenus')->insert([
			['label' => 'Série 1', 'order' => 1, 'link' => '/serie/serie-1', 'menu_id' => 1],
			['label' => 'Série 2', 'order' => 2, 'link' => '/serie/serie-2', 'menu_id' => 1],
			['label' => 'Tout', 'order' => 3, 'link' => '/category/category-1', 'menu_id' => 1],
		]);

		Contact::factory()->count(5)->create();

		// Pages
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

		// Footer
		DB::table('footers')->insert([
			['label' => 'Accueil', 'order' => 1, 'link' => '/'],
			['label' => 'Terms', 'order' => 3, 'link' => '/pages/terms'],
			['label' => 'Policy', 'order' => 4, 'link' => '/pages/privacy-policy'],
			['label' => 'Contact', 'order' => 5, 'link' => '/contact'],
		]);

		// Setting
		DB::table('settings')->insert([
			['key' => 'pagination', 'value' => 6],
			['key' => 'excerptSize', 'value' => 45],
			['key' => 'title', 'value' => 'Laravel'],
			['key' => 'subTitle', 'value' => 'Un framework qui rend heureux'],
			['key' => 'flash', 'value' => ''],
			['key' => 'newPost', 'value' => 4],
		]);

		// Events
		Event::create(
			['label' => 'Version', 'description' => 'Laravel version', 'color' => 'amber', 'start_date' => now()->addDays(3), 'end_date' => null]
		);
		Event::create(
			['label' => 'Update', 'description' => 'Site update', 'color' => 'green', 'start_date' => now()->addDays(8), 'end_date' => null]
		);
		Event::create(
			['label' => 'Laracon', 'description' => 'Let`s go!', 'color' => 'blue', 'start_date' => now()->addDays(13), 'end_date' => now()->addDays(15)]
		);

		$this->call([
			SurveySeeder::class,
			QuizSeeder::class,
		]);
	}

	protected function createPost($id, $category_id, $serie_id = null, $parent_id = null)
	{
		$months = ['03', '03', '03', '04', '04', '06', '06', '06', '06'];

		$date = generateRandomDateInRange('2022-01-01', '2024-07-01');

		return Post::factory()->create([
			'title'       => 'Post ' . $id,
			'seo_title'   => 'Post ' . $id,
			'slug'        => Str::of('Post ' . $id)->slug('-'),
			'user_id'     => rand(1, 2),
			'image'       => '2024/' . $months[$id - 1] . '/img0' . $id . '.jpg',
			'category_id' => $category_id,
			'serie_id'    => $serie_id,
			'parent_id'   => $parent_id,
			'created_at'  => $date,
			'updated_at'  => $date,
			'pinned'      => 5 == $id,
		]);
	}

	protected function createComment($post_id, $user_id, $id = null)
	{
		return Comment::factory()->create([
			'post_id'   => $post_id,
			'user_id'   => $user_id,
			'parent_id' => $id,
		]);
	}
}
