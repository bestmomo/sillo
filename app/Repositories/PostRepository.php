<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Models\Serie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository
{
	/**
	 * Récupère les posts paginés en fonction de la catégorie ou de la série.
	 */
	public function getPostsPaginate(?Category $category, ?Serie $serie): LengthAwarePaginator
	{
		$builder = $this->getBaseQuery();

		if ($category) {
			$builder->whereBelongsTo($category);
		}

		if ($serie) {
			$builder->whereBelongsTo($serie)->oldest();
		}

		return $this->getPostsWithGoodExceptsAndPaginate($builder);
	}

	/**
	 * Récupère un post par son slug.
	 */
	public function getPostBySlug(string $slug): Post
	{
		$post = Post::with('user:id,name', 'category', 'serie')
			->withCount('validComments')
			->whereSlug($slug)
			->firstOrFail();

		if ($post->serie_id) {
			$post->previous = $post->parent_id ? Post::findOrFail($post->parent_id) : null;
			$post->next     = Post::whereParentId($post->id)->first() ?: null;
		}

		return $post;
	}

	/**
	 * Recherche les posts en fonction d'un terme de recherche.
	 */
	public function search(string $search): LengthAwarePaginator
	{
		$builder = $this->getBaseQuery()
			->where(function ($query) use ($search) {
				$query->where('body', 'like', "%{$search}%")
					    ->orWhere('title', 'like', "%{$search}%");
			});
			
			return $this->getPostsWithGoodExceptsAndPaginate($builder);
	}

	/**
	 * Génère un slug unique pour un post.
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
	 * Récupère la requête de base pour les posts.
	 */
	protected function getBaseQuery(): Builder
	{
		$specificReqs = [
			'mysql'  => "LEFT(body, LOCATE(' ', body, 300))",
			'sqlite' => 'substr(body, 1, 300)',
			'pgsql'  => "substring(body from '^.{1,300}\\b')",
		];
		$usedDbSystem = env('DB_CONNECTION', 'mysql');
		$adaptedReq   = $specificReqs[$usedDbSystem];

		return Post::select('id', 'slug', 'image', 'title', 'user_id', 'category_id', 'serie_id', 'created_at')
			->selectRaw(
			 "
										CASE
												WHEN LENGTH(body) <= 300 THEN body
												ELSE {$adaptedReq}
										END AS excerpt
									",
			)
			->with('user:id,name', 'category', 'serie')
			->whereActive(true)
			->latest();
	}
	/**
	 * Récupère les posts paginés avec des extraits de 300 caractères.
	 * À noter que les mots restent entiers.
	 */
	public function getPostsWithGoodExceptsAndPaginate(Builder $builder): LengthAwarePaginator
	{
		$paginator = $builder->paginate(config('app.pagination'));
		$posts     = $paginator->items();
		foreach ($posts as $post) {
			$post->excerpt = preg_replace('/\s+\S+$/', '', $post->excerpt);
			$post->excerpt = rtrim($post->excerpt, '-.;,!?…');
		}
		 $paginator = new LengthAwarePaginator($posts, $paginator->total(), $paginator->perPage(), $paginator->currentPage(), [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);
		
		return $paginator;
	}
}
