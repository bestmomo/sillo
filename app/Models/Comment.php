<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'body',
		'post_id',
		'user_id',
		'parent_id',
	];

	/**
	 * One to Many relation.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * One to Many relation.
	 */
	public function post(): BelongsTo
	{
		return $this->belongsTo(Post::class);
	}

	// La relation pour obtenir le parent d'un commentaire
	public function parent(): BelongsTo
	{
		return $this->belongsTo(Comment::class, 'parent_id');
	}

	// La relation pour obtenir les enfants d'un commentaire
	public function children(): HasMany
	{
		return $this->hasMany(Comment::class, 'parent_id');
	}

	// Une fonction récursive pour calculer la profondeur
	public function getDepth(): int
	{
		return $this->parent ? $this->parent->getDepth() + 1 : 0;
	}
}
