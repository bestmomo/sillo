<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */


/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;


use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		Contact::factory()->count(5)->create();
	}
}
