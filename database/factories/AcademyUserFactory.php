<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AcademyUserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @param mixed $idPrev
	 * @return array<string, mixed>
	 */
	public function definition($idPrev = 1): array
	{
		return [
			'password'       => Hash::make('password'),
			'remember_token' => Str::random(10),
			'valid'          => true,
		];
	}
}
