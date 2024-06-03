<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Tag extends Model
{
    protected $fillable = ['tag'];
    public $timestamps = false;

    public function posts(): belongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
