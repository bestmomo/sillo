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
	 */
	public function posts(): HasMany
	{
		return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id');
	}

	public function lastPost(): Post
	{
		return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id')->first();
	}

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
