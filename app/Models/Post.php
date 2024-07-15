<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
	use HasFactory;
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'slug',
		'excerpt',
		'body',
		'active',
		'image',
		'user_id',
		'serie_id',
		'serie_number',
		'category_id',
		'seo_title',
		'meta_description',
		'meta_keywords',
		'pinned',
	];

	/**
	 * Get user of the Post.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Get the category for the post.
	 */
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	/**
	 * Get the serie for the post.
	 */
	public function serie(): BelongsTo
	{
		return $this->belongsTo(Serie::class);
	}

	/**
	 * Get all comments for the post.
	 */
	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	/**
	 * Get all valid comments for the post.
	 */
	public function validComments(): HasMany
	{
		return $this->comments()->whereHas('user', function ($query) {
			$query->whereValid(true);
		});
	}
}
