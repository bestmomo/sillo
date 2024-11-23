<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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
	];

	/**
	 * Has Many relation.
	 */
	public function posts(): HasMany
	{
		return $this->hasMany(Post::class);
	}

	/**
	 * Has Many relation.
	 */
	public function series(): HasMany
	{
		return $this->hasMany(Serie::class);
	}
}
