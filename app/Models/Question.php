<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Question extends Model {
	use HasFactory;

	public $timestamps  = false;
	protected $fillable = ['question_text', 'quiz_id'];

	/**
	 * Retrieve the answers associated with this question.
	 */
	public function answers(): HasMany {
		return $this->hasMany(Answer::class);
	}

	/**
	 * Retrieve the quiz associated with this question.
	 */
	public function quiz(): BelongsTo {
		return $this->belongsTo(Quiz::class);
	}
}
