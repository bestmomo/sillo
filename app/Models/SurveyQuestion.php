<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class SurveyQuestion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['question_text', 'survey_id'];

	/**
	 * Retrieve the survey associated with this question.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function survey(): BelongsTo
	{
		return $this->belongsTo(Survey::class);
	}

    /**
     * Retrieve the answers associated with this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function answers(): HasMany
	{
		return $this->hasMany(SurveyAnswer::class);
	}
}
