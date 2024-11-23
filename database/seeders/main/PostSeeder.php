<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Main;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
	use WithoutModelEvents;

	public static $nbrPosts;

	public function run()
	{
		$nbrCategories = CategorySeeder::$nbrCategories;

		$this->createPost(1, 1, 1);
		$this->createPost(2, rand(1, $nbrCategories));
		$this->createPost(3, 1, 1, 1);
		$this->createPost(4, 1, 1, 3);
		$this->createPost(5, rand(1, $nbrCategories));
		$this->createPost(6, 1, 2);
		$this->createPost(7, 1, 2, 6);
		$this->createPost(8, rand(1, $nbrCategories));
		$this->createPost(9, rand(1, $nbrCategories));

		self::$nbrPosts = DB::table('posts')->count();
	}

	protected function createPost($id, $category_id, $serie_id = null, $parent_id = null)
	{
		$months = ['03', '03', '03', '04', '04', '06', '06', '06', '06'];

		$date = generateRandomDateInRange('2022-01-01', '2024-07-01');

		$postId = "Post {$id}";

		return Post::factory()->create([
			'title'       => $postId,
			'seo_title'   => $postId,
			'slug'        => Str::of($postId)->slug('-'),
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
}
