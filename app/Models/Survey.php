<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

class Survey extends Model {
	use HasFactory;

	protected $fillable = ['title', 'description', 'user_id', 'active'];

	/**
	 * Define a one-to-many relationship for the Surevy model, retrieving the user associated with it.
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	/**
	 * Define a one-to-many relationship for the Survey model, retrieving all questions associated with it.
	 */
	public function questions(): HasMany {
		return $this->hasMany(SurveyQuestion::class);
	}

	/**
	 * Define a many-to-many relationship for the Survey model, retrieving all participants associated with it.
	 */
	public function participants(): BelongsToMany {
		return $this->belongsToMany(User::class, 'survey_user')
			->withPivot('answers')
			->withTimestamps();
	}
}
