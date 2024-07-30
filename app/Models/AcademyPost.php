<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyPost extends Model
{
	use HasFactory;

	protected $table    = 'academy_posts';
	protected $fillable = [
		'title',
		'content',
	];
}
