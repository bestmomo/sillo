<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'liked',
        'ip_address',
    ];

    // Relation avec le modèle Comment
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
