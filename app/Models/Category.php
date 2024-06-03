<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $fillable = [
        'title', 
        'slug',
    ];

    public $timestamps = false;

    /**
     * Has Many relation
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

        /**
     * Has Many relation
     */
    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }
}
