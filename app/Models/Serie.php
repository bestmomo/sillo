<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Serie extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'slug',
		'category_id',
		'user_id',
	];

	/**
	 * Has Many relation.
	 */
	public function posts(): HasMany
	{
		return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id');
	}

	/**
	 * Has Many relation.
	 */
	public function lastPost(): ?Post
	{
		// Récupérer tous les posts pertinents en une seule requête avec les colonnes spécifiées
		$posts = $this->hasMany(Post::class)
					  ->select('id', 'title', 'serie_id', 'parent_id')
					  ->get();
	
		// Trouver le post racine (celui dont parent_id est NULL)
		$rootPost = $posts->firstWhere('parent_id', null);
	
		if (!$rootPost) {
			return null; // Aucun post racine trouvé
		}
	
		$currentPost = $rootPost;
	
		// Suivre la chaîne de parent_id jusqu'au dernier post
		while (true) {
			$nextPost = $posts->firstWhere('parent_id', $currentPost->id);
			if (!$nextPost) {
				break;
			}
			$currentPost = $nextPost;
		}
	
		return $currentPost;
	}

	/**
	 * Has One relation to Category model.
	 */
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	/**
	 * Retrieve the associated User model for this Serie.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
