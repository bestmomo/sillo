<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Contact::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name'    => fake()->name,
			'email'   => fake()->unique()->safeEmail,
			'message' => fake()->realText($maxNbChars = 200, $indexSize = 2),
		];
	}
}
