<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

namespace Database\Seeders\Academy;

use App\Models\AcademyUser;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademyUserSeeder extends Seeder
{
	use WithoutModelEvents;

	// Définir NB, nombres d'users à crééer
	// (Les 5 premiers sont forcés)
	// ATTENTION: Compter env. 10' pour 3 000 users générés...
	public const NB = 10; 

	public $data;
	public $nb;	
	public $dates;

	public function run()
	{
		AcademyUser::truncate();

		$this->nb = self::NB;

		$us = $this->makeNbUsers();

		AcademyUser::factory()->createMany($us);

		// $unValidUser        = AcademyUser::find(4);
		// $unValidUser->valid = false;
		// $unValidUser->save();
	}

	public function simuUsers()
	{
		return [
			[
				'name'          => 'CÔTE',
				'firstname'     => 'AdminLionel',
				'email'         => 'admin@example.com',
				'role'          => 'tutor',
				'parr'          => 0,
				'academyAccess' => true,
				'created_at'    => Carbon::now()->subYears(3),
				'updated_at'    => Carbon::now()->subYears(3),
			],
		];
	}

	public function normalize($str)
	{
		$transliteration = [
			'à' => 'a',
			'â' => 'a',
			'ä' => 'a',
			'á' => 'a',
			'ã' => 'a',
			'å' => 'a',
			'ç' => 'c',
			'è' => 'e',
			'é' => 'e',
			'ê' => 'e',
			'ë' => 'e',
			'ì' => 'i',
			'í' => 'i',
			'î' => 'i',
			'ï' => 'i',
			'ñ' => 'n',
			'ò' => 'o',
			'ó' => 'o',
			'ô' => 'o',
			'õ' => 'o',
			'ö' => 'o',
			'ù' => 'u',
			'ú' => 'u',
			'û' => 'u',
			'ü' => 'u',
			'ý' => 'y',
			'ÿ' => 'y',
			' ' => '-',
		];

		return strtr($str, $transliteration);
	}

	/**
	 * Fait "$this->nb" fake academy_users
	 * 
	 * ATTENTION - ATTENTION - ATTENTION - ATTENTION - ATTENTION - ATTENTION - ATTENTION :
	 * Algo optimisé pour avoir une liste presque 'naturelle' de users bien nommés.
	 * (Au passage, remplacer: APP_FAKER_LOCALE=fr_FR par APP_FAKER_LOCALE=it_IT ou de_DE, etc...)
	 * 
	 * En contre-partie, le nombre demandé doit rester 'petit' (Ici, 777).
	 * À contrario, la boucle qui génère les users pourrait prendre beaucoup de temps...
	 * 
	 * Si vous souhaitez un nombre énorme d'users, préférer un algo qui utilisera un iterator,
	 * (Avec l'usage de @yield au lieu d'un array...)
	 * et rajouter un index aux doubles 😉 !
	 * 
	 * @return array ($us)
	 */
	private function makeNbUsers()
	{
		// us = users
		$us = array_merge($this->podium(), $this->mainUsersMaker());
		// $us = $this->podium();

		// start_measure('render dates', 'Time for generating dates');
		$dates = $this->generateDates(max(count($us), $this->nb));
		// stop_measure('render dates');

		// dump(...array_map(function ($u) { return $u->getAttributes(); }, $us));

		// sort($us);

		// $fakes = array_map(function ($u) {
		// 	return $u->getAttributes();
		// }, $us);

		//2do Penser à invalider user #6

		return array_map(function ($u, $i) use ($dates)
		{
			$u['id']         = $i + 1;
			$u['created_at'] = $dates[$i]->created;
			$u['updated_at'] = $dates[$i]->updated;

			// $u->updated_at =...
			return $u;
		}, $us, array_keys($us));

		// Inutile : Fait / le factory
		// foreach ($users as $u)
		// {
			//	$u->save();
		//}
		// return $us;
	}

	private function mainUsersMaker()
	{
		$us = [];

		$wantedNumber = self::NB - 5;

		for ($i = 0; $i < $wantedNumber; $i++)
		{
			$newUser = $this->fakeUser();
			if (!in_array($newUser, $us))
			{
				$us[] = $newUser;
			}
		}

		// foreach ($us as $u) {
		// 		dump($u->getAttributes());
		// } // <=> :
		// dump(...array_map(function ($u) { return $u->getAttributes(); }, $us));

		// Le arr ci-dessous récupéré est dédoublonné et réindexé :-)
		// Mais plus utile ici
		// return [...array_values(array_unique($us))];
		return $us;
	}

	private function generateDates($nb)
	{
		define ('SILLO_DOB', '2012-07-07');
		$dates = [];
		for ($i = 0; $i < $nb; $i++)
		{
			$date = new \StdClass();
			// $date->created = fake()->dateTimeBetween(SILLO_DOB, 'now');
			$date->created = fake()->dateTimeBetween(SILLO_DOB, '+1 year');

			$dates[] = $date;
		}

		sort($dates);
		var_dump($dates);

		return array_map(function ($date)
		{
			$date->updated = fake()->dateTimeBetween($date->created, '+1 year');

			return $date;
		}, $dates);

		// dump($dates);
	}

	private function podium()
	{
		$fixedUsers = [
			['firstname' => 'Marc', 'name' => 'Hautpolo'],
			['firstname' => 'Pier', 'name' => 'Kiroule'],
			['firstname' => 'Pol', 'name' => 'Hauchon'],
			['firstname' => 'Jack', 'name' => 'Haddi'],
			['firstname' => 'Lionel', 'name' => 'Sillowebsite'],
		];

		foreach ($fixedUsers as $i => $user)
		{
			$u = [
				'id'            => $i + 1,
				'gender'        => 'male',
				'name'          => $user['name'],
				'firstname'     => $user['firstname'],
				'email'         => $this->normalize(mb_strtolower($user['firstname'] . '.' . $user['name'])) . '@example.com',
				'academyAccess' => true,
				'role'          => 'student',
				'parr'          => 1,
			];

			if (1 === $u['id'])
			{
				$u['parr'] = 0;
				$u['role'] = 'tutor';
			}

			$podium[] = $u;
		}

		return $podium;
	}
}
