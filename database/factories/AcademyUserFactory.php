<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AcademyUserFactory extends Factory
{
	/**
	 * The current password being used by the factory.
	 */
	protected static ?string $password;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition($idPrev=1): array
	{
		// 2fix email: prenom.nom@example.com (Devant être unique)
		
		$gender = fake()->randomElement(['unknown', 'female', 'male']);
		
		$idPrev         += 1;
		
		$role = fake()->randomElement(['none', 'student', 'tutor']);
		// $count = DB::table('academy_users')->count();
		$parr = $idPrev;
		
		return [
			'firstname'      => ('male' == $gender) ? fake()->firstNameMale() : (('female' == $gender) ? fake()->firstNameFemale(): fake()->firstName()),
			'name'           => fake()->lastname(),
			'email'          => fake()->unique()->safeEmail(),
			'gender'         => $gender,
			'password'       => static::$password ??= Hash::make('password'),
			'remember_token' => Str::random(10),
			
			'role'=>$role,
			'parr'=>$parr
		];
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 */
	public function unverified(): static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}
}
