<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\academy;

use Carbon\Carbon;
use App\Models\AcademyPost;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AcademyPostSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		AcademyPost::factory()->count(9)->create();

	}
}
