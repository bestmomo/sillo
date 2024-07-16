<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['question_text', 'quiz_id'];

	public function answers(): HasMany
	{
		return $this->hasMany(Answer::class);
	}
	
	public function quiz(): BelongsTo
	{
		return $this->belongsTo(Quiz::class);
	}
}
