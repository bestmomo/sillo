<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Repositories;

use App\Models\{Category, Post, Serie, user};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository
{
	/**
	 * Retrieves paginated posts based on the provided category and serie.
	 *
	 * @param null|Category $category the category to filter the posts by
	 * @param null|Serie    $serie    the serie to filter the posts by
	 *
	 * @return LengthAwarePaginator the paginated posts
	 */
	public function getPostsPaginate(?Category $category, ?Serie $serie): LengthAwarePaginator
	{
		$query = $this->getBaseQuery()->orderBy('pinned', 'desc')->latest();

		if ($category) {
			$query->whereBelongsTo($category);
		}

		if ($serie) {
			$query->whereBelongsTo($serie)->oldest();
		}

		return $query->paginate(config('app.pagination'));
	}

	/**
	 * Retrieves a post by its slug.
	 *
	 * @param string $slug the slug of the post
	 *
	 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the post
	 *                                                              with the given slug is not found
	 *
	 * @return Post the post with its associated user, category, serie, quiz,
	 *              valid comments count, and favorite status
	 */
	public function getPostBySlug(string $slug): Post
	{
		$userId = auth()->id();

		$post = Post::with([
			'user:id,name',
			'category',
			'serie',
			'quiz:id,post_id',
			'quiz.participants' => function ($query) use ($userId) {
				$query->where('user_id', $userId);
			},
		])
			->withCount('validComments')
			->withExists([
				'favoritedByUsers as is_favorited' => function ($query) use ($userId) {
					$query->where('user_id', $userId);
				},
			])
			->whereSlug($slug)
			->firstOrFail();

		if ($post->serie_id) {
			$post->previous = $post->parent_id ? Post::findOrFail($post->parent_id) : null;
			$post->next     = Post::whereParentId($post->id)->first() ?: null;
		}

		return $post;
	}

	/**
	 * Searches for posts based on a given search term.
	 *
	 * @param string $search the search term to search for
	 *
	 * @return LengthAwarePaginator the paginated list of posts that match the search term
	 */
	public function search(string $search): LengthAwarePaginator
	{
		return $this->getBaseQuery()
			->latest()
			->where(function ($query) use ($search) {
				$query->where('body', 'like', "%{$search}%")->orWhere('title', 'like', "%{$search}%");
			})
			->paginate(config('app.pagination'));
	}

	/**
	 * Retrieves the favorite posts for a specific user.
	 *
	 * @param user $user The user for whom to retrieve favorite posts
	 *
	 * @return LengthAwarePaginator The paginated list of favorite posts
	 */
	public function getFavoritePosts(user $user): LengthAwarePaginator
	{
		return $this->getBaseQuery()
			->whereHas('favoritedByUsers', function (Builder $query) {
				$query->where('user_id', auth()->id());
			})
			->latest()
			->paginate(config('app.pagination'));
	}

	/**
	 * Generates a unique slug for an article.
	 *
	 * @param string $slug the original slug to generate a unique version of
	 *
	 * @return string the generated unique slug
	 */
	public function generateUniqueSlug(string $slug): string
	{
		$newSlug = $slug;
		$counter = 1;
		while (Post::where('slug', $newSlug)->exists()) {
			$newSlug = $slug . '-' . $counter;
			++$counter;
		}

		return $newSlug;
	}

	/**
	 * Retrieves the base query for articles.
	 *
	 * @return Builder The base query for articles
	 */
	protected function getBaseQuery(): Builder
	{
		$specificReqs = [
			'mysql'  => "LEFT(body, LOCATE(' ', body, 350))",
			'sqlite' => 'substr(body, 1, 350)',
			'pgsql'  => 'substring(body from 1 for 350)',
		];

		$usedDbSystem = env('DB_CONNECTION', 'mysql');

		if (!isset($specificReqs[$usedDbSystem])) {
			throw new Exception("Base de données non supportée: {$usedDbSystem}");
		}

		$adaptedReq = $specificReqs[$usedDbSystem];

		return Post::select('id', 'slug', 'image', 'title', 'user_id', 'category_id', 'serie_id', 'created_at', 'pinned')
			->selectRaw(
				"CASE
                    WHEN LENGTH(body) <= 300 THEN body
                    ELSE {$adaptedReq}
                END AS excerpt",
			)
			->when($userId = auth()->id(), function ($query, $userId) {
				$query->selectRaw('(SELECT 1 FROM favorites WHERE favorites.post_id = posts.id AND favorites.user_id = ?) AS is_favorited', [$userId]);
			})
			->with('user:id,name', 'category', 'serie')
			->whereActive(true);
	}
}
