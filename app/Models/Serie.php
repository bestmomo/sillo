<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
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
	 *
	 * @return HasMany
	 */
	public function posts(): HasMany
	{
		return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id');
	}

	/**
	 * Has Many relation.
	 *
	 * @return Post
	 */
	public function lastPost(): Post
	{
		return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id')->first();
	}

	/**
	 * Has One relation to Category model.
	 *
	 * @return BelongsTo
	 */
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	/**
	 * Retrieve the associated User model for this Serie.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
