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
	public static $totalCount;

	/**
	 * Define the model's default state.
	 *
	 * @param mixed $idPrev
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		static $iConsole = 0;
		
		$modulo         = self::$totalCount / 100;
		$iConsole++;
		// if (0 == $iConsole++ % $modulo) 
			printf('%s%s%s', str_repeat(' ', 2), $iConsole . ' / ', self::$totalCount);
			
			// printf ("\r2%s", str_repeat(' ', 2));
			printf ("\r");
		// }

		return [
			'password'       => Hash::make('password'),
			'remember_token' => Str::random(10),
			'valid'          => true,
		];
	}
}
