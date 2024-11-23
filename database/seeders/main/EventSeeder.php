<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Seeders\Main;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
	use WithoutModelEvents;

	public function run()
	{
		$events = [
			[
				'label'       => 'Version',
				'description' => 'Laravel version',
				'color'       => 'amber',
				'start_date'  => now()->addDays(3),
				'end_date'    => null,
			],
			[
				'label'       => 'Update',
				'description' => 'Site update',
				'color'       => 'green',
				'start_date'  => now()->addDays(8),
				'end_date'    => null,
			],
			[
				'label'       => 'Laracon',
				'description' => 'Let`s go!',
				'color'       => 'blue',
				'start_date'  => now()->addDays(13),
				'end_date'    => now()->addDays(15),
			],
		];

		foreach ($events as $eventData)
		{
			Event::create($eventData);
		}
	}
}
