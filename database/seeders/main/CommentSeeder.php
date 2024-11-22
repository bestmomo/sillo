<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Main;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder {
	use WithoutModelEvents;

	public function run() {
		$nbrPosts = PostSeeder::$nbrPosts;
		$nbrUsers = UserSeeder::$nbrUsers;
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
	}

	protected function createComment($post_id, $user_id, $id = null) {
		return Comment::factory()->create([
			'post_id' => $post_id,
			'user_id' => $user_id,

			'parent_id' => $id,
		]);
	}
}
