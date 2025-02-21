<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Carbon\Carbon;
use App\Models\AcademyUser;
use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class() extends Component
{
	public const NB = 10;

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
		$users = $this->makeNUsers();

		// Affectation des dates cohérentes
		// 
		// $users = array_map(function ($user) {
		//$user->password = Hash::make('password');		
		//$user->remember_token = Str::random(10);		
		// $user->created_at =...
		// $user->updated_at =...
		// 	return $user->getAttributes();
		// }, $users);

		// foreach ($users as $u)
		// {
			//	$u->save();
		//}

		return [
			// 'users' => AcademyUser::limit(7)->get('firstname'),
			// 'var'   => $this->usersCount(),
			'users' => $users,
			'fakes' => array_map(function ($user)
			{
				return $user->getAttributes();
			}, $users),
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
	 * 
	 * @return array ($us)
	 */
	private function makeNUsers()
	{
		$start = Carbon::now()->subYears(3);  // Il y a 3 ans
		$end   = Carbon::now()->addYear(); // Dans 1 an

		$us = $this->mainUsersMaker($start, $end); // us = users
		$this->showCount($us);
		// $us = $this->replaceDuplicated($us, $start, $end);

		// sort($us);

		$this->showCount($us);

		// $fakes = array_map(function ($u) {
		// 	return $u->getAttributes();
		// }, $us);
		return $us;
	}

	private function showCount($us)
	{
		echo self::NB . ' → Final: ' . count($us) . '<hr>';
	}

	private function replaceDuplicated($us)
	{
		$n = count($us);
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
		for ($i = 0; $i < self::NB; $i++)
		{
			// $us[] = $this->fakeUser();
			$us[] = $this->fakeUser();
			// $u->save();
		}

		return [...array_values(array_unique($us))];
	}

	private function usersCount()
	{
		return AcademyUser::count();
	}

	private function fakeName()
	{
		return fake()->name();
	}

	private function fakeUser()
	{
		/**
		 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
		 */
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
		$parr = abs($parrId);

		// 2fix: Calcul des bornes left et right au fur et à mesure des enregistrements

		$u                = new AcademyUser();
		$u->gender        = $gender;
		$u->name          = fake()->lastName();
		$u->firstname     = $firstName;
		$u->email         = $this->normalize(mb_strtolower($u->firstname . '.' . $u->name)) . '@example.com';
		$u->academyAccess = $academyAccess;
		$u->role          = $role ?? 'none';
		$u->parr          = $parr;
		$u->password = Hash::make('password');		
		$u->remember_token = Str::random(10);	
		return $u;
	}
};