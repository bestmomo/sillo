<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class SurveyQuestion extends Model {
	use HasFactory;

	public $timestamps  = false;
	protected $fillable = ['question_text', 'survey_id'];

	/**
	 * Retrieve the survey associated with this question.
	 */
	public function survey(): BelongsTo {
		return $this->belongsTo(Survey::class);
	}

	/**
	 * Retrieve the answers associated with this question.
	 */
	public function answers(): HasMany {
		return $this->hasMany(SurveyAnswer::class, 'question_id');
	}
}
