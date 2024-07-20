<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, BelongsToMany};

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    /**
     * Define a one-to-many relationship for the Surevy model, retrieving the user associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a one-to-many relationship for the Survey model, retrieving all questions associated with it.
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    /**
     * Define a many-to-many relationship for the Survey model, retrieving all participants associated with it.
     *
     * @return BelongsToMany
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'survey_user')
            ->withPivot('question', 'answer')
            ->withTimestamps();
    }
}
