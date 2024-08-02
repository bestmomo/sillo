<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace database\seeders\academy;

use App\Models\AcademyPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademyPostSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		AcademyPost::factory()->count(9)->create();
	}
}
