<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use App\Models\AcademyUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Volt\Component;

new class() extends Component
{
	//2do trouver limite
	public const NB = 100;
	//2do cf mesure du temps avec debugbar

	public $data;
	public $nb;	
	private $dates;

	public function mount()
	{
		// $email = $this->normalize(mb_strtolower('ÉléänaÏs' . '.' . 'de La CÔTE')) . '@example.com';
		// echo $email,'<hr>';

		$this->nb = self::NB;
	}

	public function with()
	{
		start_measure('render', 'Time for generating users');
		$users = $this->makeNbUsers();
		stop_measure('render users');
		
		start_measure('render', 'Time for generating dates');
		$dates = $this->generateDates();
		stop_measure('render dates');

		//2do // Affectation des dates cohérentes
		// 
		// $users = array_map(function ($user) {
		// $user->created_at =...
		// $user->updated_at =...
		// 	return $user->getAttributes();
		// }, $users);

		// foreach ($users as $u)
		// {
			//	$u->save();
		//}

		//2do Penser à invalider user #6

		return [
			// 'users' => AcademyUser::limit(7)->get('firstname'),
			// 'var'   => $this->usersCount(),
			'users' => $users ?? null,
			'fakes' => $dates ?? null,
			// 'fakes' => array_map(function ($user)
			// {
			// 	return $user->getAttributes();
			// }, $users),
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

	private function generateDates()
	{
		define ('SILLO_DOB', '2012-07-07');
		$dates = [];
		for ($i = 0; $i < self::NB; $i++)
		{
			$date = new StdClass();
			// $date->created = fake()->dateTimeBetween(SILLO_DOB, 'now');
			$date->created = fake()->dateTimeBetween(SILLO_DOB, '+1 year');

			$dates[] = $date;
		}

		sort($dates);

		return array_map(function ($date)
		{
			$date->updated = fake()->dateTimeBetween($date->created, '+1 year');

			return $date;
		}, $dates);

		// dump($dates);
	}

	private function podium()
	{
		$users = [
			['firstname' => 'Marc', 'name' => 'Hautpolo'],
			['firstname' => 'Pier', 'name' => 'Kiroule'],
			['firstname' => 'Pol', 'name' => 'Hauchon'],
			['firstname' => 'Jack', 'name' => 'Haddi'],
			['firstname' => 'Lionel', 'name' => 'Sillowebsite'],
		];

		foreach ($users as $i => $user)
		{
			// dump($user);
			$u                 = new AcademyUser();
			$u->id             = $i + 1;
			$u->gender         = 'male';
			$u->name           = $user['name'];
			$u->firstname      = $user['firstname'];
			$u->email          = $this->normalize(mb_strtolower($user['firstname'] . '.' . $user['name'])) . '@example.com';
			$u->academyAccess  = 1;
			$u->role           = 'student';
			$u->parr           = 1;
			$u->password       = Hash::make('password');		
			$u->remember_token = Str::random(10);
			// dump($u->getAttributes());
			if (1 == $u->id)
			{
				$u->parr = null;
				$u->role = 'tutor';
			}
			elseif (5 == $u->id)
			{
				$u->parr = 1;
			}
			$podium[] = $u;
		}

		return $podium;
	}

	/**
	 * Fait "$this->nb" fake users, en éliminant les doublons, en les triant, puis en affichant les compteurs
	 * (Nombre demandés, et obtenus, une fois l'arr dédoublonné), et ce en 2 temps :
	 * 
	 * 1ère étape: Fait le gros de la liste
	 * 2ème étape: remplace les doublons tant qu'on a pas le nombre demandé.
	 * 
	 * ATTENTION - ATTENTION - ATTENTION - ATTENTION - ATTENTION - ATTENTION - ATTENTION :
	 * Algo optimisé pour avoir une liste presque 'naturelle' de users bien nommés.
	 * (Au passage,possible de remplacer: APP_FAKER_LOCALE=fr_FR par APP_FAKER_LOCALE=it_IT ou de_DE, etc...)
	 * En contre-partie, le nombre demandé doit rester 'petit' (Ici, 1e3).
	 * À contrario, la boucle qui remplace les doublons ne jamais aboutir...
	 * 
	 * Si vous souhaitez un nombre énorme d'users, préférer un algo qui rajoutera un index aux doubles 😉 !
	 * (Et d'utiliser par ailleurs, utiliser un @yield au lieu d'un array...)
	 * 
	 * @return array ($us)
	 */
	private function makeNbUsers()
	{
		$us = array_merge($this->podium(), $this->mainUsersMaker()); // us = users
		$this->showCount($us, 'Génération majeure dédoublonnée');

		// $us = $this->replaceDuplicated($us);
		// $this->showCount($us, 'Après remplacement des doublons');

		// dump(...array_map(function ($u){ return $u->getAttributes(); }, $us));

		// sort($us);

		// $fakes = array_map(function ($u) {
		// 	return $u->getAttributes();
		// }, $us);
		return $us;
	}

	private function showCount($us, $msg = null)
	{
		if ($msg)
		{
			$msg = " ({$msg})";
		} 
		echo  'Demandés: ' . self::NB . ' → Obtenus: ' . count($us) . '<i>' . $msg . '</i>' . '<hr>';
	}

	private function replaceDuplicated($us)
	{
		$n = count($us);
		dump($n);
		while ($n < self::NB)
		{
			echo '*<br>';
			$us[] = $this->fakeUser();
			$us   = [...array_values(array_unique($us))];
			$n    = count($us);
		}

		return $us;
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

		//2ar faux doubles
		// $us[2]          = $us[0]; // on créée 1 faux double pour test
		// $us[3]          = $us[2]; // on créée 1 faux double pour test

		// foreach ($us as $u) {
		// 		dump($u->getAttributes());
		// } // <=> :
		// dump(...array_map(function ($u) { return $u->getAttributes(); }, $us));

		// Le arr récupéré est réindexé :-)
		return [...array_values(array_unique($us))];
	}

	// private function usersCount()
	// {
	// 	return AcademyUser::count();
	// }

	private function fakeName()
	{
		return fake()->name();
	}

	private function fakeUser()
	{
		static $parrId = 1;
		--$parrId;
		$gender    = fake()->randomElement(['unknown', 'female', 'male']);
		$firstName = ('male' == $gender) ? fake()->firstNameMale() : (('female' == $gender) ? fake()->firstNameFemale() : fake()->firstName());
		// accessAcademy: 0=non (70%), 1=oui (25%)
		$academyAccess = (fake()->numberBetween(1, 10) <= 7) ? 0 : 1;
		// role: none: pour les 70% ci-dessus, tutor: 7% des 25%, student: le reste
		if ($academyAccess)
		{
			$role = (fake()->numberBetween(1, 10) <= 9) ? 'student' : 'tutor';
		}

		// 2fix: parr pris au hazard parmi les users déjà enregistrés, si n'a pas déjà 7 filleuls
		// Pour l'heure, le parrain est le précédent enregistré
		$parr = abs($parrId) + 2;

		// 2fix: Calcul des bornes left et right au fur et à mesure des enregistrements

		$u = new AcademyUser();
		// $u->id             = $i + 6;
		$u->gender         = $gender;
		$u->name           = fake()->lastName();
		$u->firstname      = $firstName;
		$u->email          = $this->normalize(mb_strtolower($u->firstname . '.' . $u->name)) . '@example.com';
		$u->academyAccess  = $academyAccess;
		$u->role           = $role ?? 'none';
		$u->parr           = $parr;
		$u->password       = Hash::make('password');		
		$u->remember_token = Str::random(10);

		return $u;
	}
};
