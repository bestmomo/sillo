<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model {
	use HasFactory;

	public $timestamps  = false;
	protected $fillable = ['answer_text', 'question_id'];

	/**
	 * Get the question that the answer belongs to.
	 */
	public function question(): BelongsTo {
		return $this->belongsTo(SurveyQuestion::class);
	}
}
