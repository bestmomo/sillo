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
class AcademyUserFactory_ori extends Factory
{
	/**
	 * The current password being used by the factory.
	 */
	protected static ?string $password;

	/**
	 * Define the model's default state.
	 *
	 * @param mixed $idPrev
	 * @return array<string, mixed>
	 */
	public function definition($idPrev = 1): array
	{
		// Note: APP_FAKER_LOCALE=fr_FR définit la locale de Faker
		// 2fix email: prenom.nom@example.com (Devant être unique)

		static $parrId = 1;
		--$parrId;

		$gender = fake()->randomElement(['unknown', 'female', 'male']);

		// accessAcademy: 0=non (70%), 1=oui (25%)
		$academyAccess = (fake()->numberBetween(1, 10) <= 7) ? 0 : 1;

		// role: none: pour les 70% ci-dessus, tutor: 7% des 25%, student: le reste
		if ($academyAccess)
		{
			$role = (fake()->numberBetween(1, 10) <= 9) ? 'student' : 'tutor';
		}

		// 2fix: parr pris au hazard parmi les users déjà enregistrés, si n'a pas déjà 7 filleuls
		// Pour l'heure, le parrain est le précédent enregistré
		$parr = abs($parrId);

		//2do list($firstname, $name, $email) = $this->uniqueUserNameAndEmail($gender);

		// 2fix: Calcul des bornes left et droite au fur et à mesure des enregistrements

		return [
			'firstname'      => ('male' == $gender) ? fake()->firstNameMale() : (('female' == $gender) ? fake()->firstNameFemale() : fake()->firstName()),
			'name'           => fake()->lastname(),
			'email'          => fake()->unique()->safeEmail(),
			'gender'         => $gender,
			'password'       => static::$password ??= Hash::make('password'),
			'remember_token' => Str::random(10),

			'academyAccess' => $academyAccess,
			'role'          => $role ?? 'none',
			'parr'          => $parr,
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

	public function uniqueUserNameAndEmail($gender)
	{
		static $emails;

		$name      = fake()->lastname();
		$firstname = ('male' == $gender) ? fake()->firstNameMale() : (('female' == $gender) ? fake()->firstNameFemale() : fake()->firstName());
		$email          = 'a' . 'b';

		if (!isset($names[$name]))
		{
			$email[$email] = 1;

			self::$users[] = $pseudo = $name;
		}
		else
		{
			$names[$name]++;
			$pseudo = self::$users[] = $name . '-' . ($names[$name] - 1);
		}

		$email = strtolower(str_replace(' ', '_', $pseudo) ) . '@example.com';

		return [$name, $email];
	}

	// private function fakeFakes() {
	// 	static $n  = 0;
	// 	$fakeFakes = ['a', 'b', 'a', 'b', 'd', 'a', 'e'];

	// 	return $fakeFakes[$n++ % count($fakeFakes)];
	// }
}
