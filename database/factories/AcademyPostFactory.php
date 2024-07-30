<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AcademyPostFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		static $postNumber = 1;

		return [
			'title'   => 'Post ' . $postNumber++,
			'content' => fake()->paragraphs(3, true),
		];
	}
}
