<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, BelongsToMany};

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'post_id'];

    /**
     * Define a one-to-many relationship for the Quiz model, retrieving all questions associated with it.
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Define a one-to-many relationship for the Quiz model, retrieving the user associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a one-to-many relationship for the Quiz model, retrieving the post associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Define a many-to-many relationship for the Quiz model, retrieving all participants associated with it.
     *
     * @return BelongsToMany
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'quiz_user')
            ->withPivot('correct_answers', 'total_answers')
            ->withTimestamps();
    }
}
