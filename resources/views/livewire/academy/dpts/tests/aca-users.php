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

	// Définir nombres d'users souhaités (Les 5 premiers sont forcés)
	// ATTENTION: Compter env. 10 'pour 3 000 !
	public const NB = 10; 
	//2do cf mesure du temps avec debugbar

	public $data;
	public $nb;	
	public $dates;

	public function mount()
	{
		$this->nb = self::NB;
	}

	public function with()
	{
		return [
			'users' => $this->makeNbUsers(),
			// 'fakes' => $this->dates,
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
		start_measure('render dates', 'Time for generating dates');
		$dates = $this->generateDates();
		stop_measure('render dates');

		// us = users
		$us = array_merge($this->podium(), $this->mainUsersMaker());

		// dump(...array_map(function ($u) { return $u->getAttributes(); }, $us));

		// sort($us);

		// $fakes = array_map(function ($u) {
		// 	return $u->getAttributes();
		// }, $us);

		$us = array_map(function ($u, $i) use ($dates){
			$u->id = $i + 1;
			$u->created_at = $dates[$i]->created;
			$u->updated_at = $dates[$i]->updated;
		// $u->updated_at =...
			return $u;
		}, $us, array_keys($us));

		// foreach ($users as $u)
		// {
			//	$u->save();
		//}

		//2do Penser à invalider user #6

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

		// foreach ($us as $u) {
		// 		dump($u->getAttributes());
		// } // <=> :
		// dump(...array_map(function ($u) { return $u->getAttributes(); }, $us));

		// Le arr ci-dessous récupéré est dédoublonné et réindexé :-)
		// Mais plus utile ici
		// return [...array_values(array_unique($us))];
		return $us;
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
