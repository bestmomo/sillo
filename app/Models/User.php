<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use HasFactory;
	use Notifiable;

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
	 * One to Many relation.
	 */
	public function posts(): HasMany
	{
		return $this->hasMany(Post::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function messages(): HasMany
	{
		return $this->hasMany(Message::class);
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

	public function scopeSearch($query, $value)
	{
		$query->where('name', 'like', "%{$value}%")
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
			'password'          => 'hashed',
		];
	}
}
