<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AcademyUser extends Authenticatable
{
	use HasFactory;
	use Notifiable;

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
	 * Scope a query to search for a specific value in the 'name', 'firstname', or 'email' columns.
	 *
	 * @param datatype $query The query builder instance
	 * @param datatype $value The value to search for
	 *
	 * @return BelongsToMany
	 */
	public function scopeSearch($query, $value)
	{
		$query
			->where('name', 'like', "%{$value}%")
			->orWhere('firstname', 'like', "%{$value}%")
			->orWhere('email', 'like', "%{$value}%");
	}
}
