<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug', 
        'body',
        'seo_title', 
        'meta_description', 
        'meta_keywords',
    ];

    public $timestamps = false;
}