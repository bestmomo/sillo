<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'valid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * One to Many relation
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * One to Many relation
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Determine if user is administrator
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

        /**
     * Determine if user is redactor
     */
    public function isRedac(): bool
    {
        return $this->role === 'redac';
    }

    /**
     * Determine if user is administrator or redactor
     */
    public function isAdminOrRedac(): bool
    {
        return $this->role === 'admin' || $this->role === 'redac';
    }
}
