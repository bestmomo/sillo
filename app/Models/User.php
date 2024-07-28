<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsToMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'firstname', 'email', 'password', 'role', 'valid', 'isStudent'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * One to Many relation.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Retrieve the comments associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Define a one to many relation for messages.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Retrieve the quizzes associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Retrieve the surveys associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class);
    }

    /**
     * Retrieve the quizzes that the user has participated in.
     *
     * @return BelongsToMany
     */
    public function participatedQuizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_user')
            ->withPivot('correct_answers', 'total_answers')
            ->withTimestamps();
    }

    /**
     * Retrieve the surveys that the user has participated in.
     *
     * @return BelongsToMany
     */
    public function participatedSurveys(): BelongsToMany
    {
        return $this->belongsToMany(Survey::class, 'survey_user')
            ->withPivot('answers')
            ->withTimestamps();
    }

    /**
     * Retrieve the user's favorite posts.
     *
     * @return BelongsToMany
     */
    public function favoritePosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favorites');
    }

    /**
     * Determine if user is administrator.
     */
    public function isAdmin(): bool
    {
        return 'admin' === $this->role;
    }

    /**
     * Determine if user is redactor.
     */
    public function isRedac(): bool
    {
        return 'redac' === $this->role;
    }

    /**
     * Determine if user is administrator or redactor.
     */
    public function isAdminOrRedac(): bool
    {
        return 'admin' === $this->role || 'redac' === $this->role;
    }

    /**
     * Scope a query to search for a specific value in the 'name', 'firstname', or 'email' columns.
     *
     * @param datatype $query The query builder instance
     * @param datatype $value The value to search for
     * @return BelongsToMany
     */
    public function scopeSearch($query, $value)
    {
        $query
            ->where('name', 'like', "%{$value}%")
            ->orWhere('firstname', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
