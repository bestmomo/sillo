<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyChatV1Message extends Model
{
	use HasFactory;

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
