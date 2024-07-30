<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'body'             => fake()->paragraphs($nb = 8, $asText = true),
			'meta_description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
			'meta_keywords'    => implode(',', fake()->words($nb = 3, $asText = false)),
			'active'           => true,
		];
	}
}
