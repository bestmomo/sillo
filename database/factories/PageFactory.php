<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory {
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Page::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			'body'             => fake()->paragraph(10),
			'meta_description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
			'meta_keywords'    => implode(',', fake()->words($nb = 3, $asText = false)),
		];
	}
}
