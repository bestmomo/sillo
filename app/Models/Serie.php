<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Serie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'slug',
        'category_id',
        'user_id',
    ];

    public $timestamps = false;

    /**
     * Has Many relation
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id');
    }

    public function lastPost(): Post
    {
        return $this->hasMany(Post::class)->latest()->select('id', 'title', 'serie_id')->first();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
