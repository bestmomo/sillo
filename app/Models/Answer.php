<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
	use HasFactory;

	public $timestamps  = false;
	protected $fillable = ['answer_text', 'is_correct', 'question_id'];

	/**
	 * Get the question that the answer belongs to.
	 */
	public function question(): BelongsTo
	{
		return $this->belongsTo(Question::class);
	}
}
