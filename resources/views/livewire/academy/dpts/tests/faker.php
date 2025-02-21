<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use App\Models\AcademyUser;
use Livewire\Volt\Component;

new class() extends Component
{
	public $data;
	public $nb;

	public function mount()
	{
		$this->nb = 1e3;
	}

	public function with()
	{
		return [
			// 'users' => AcademyUser::limit(7)->get('firstname'),
			// 'var'   => $this->usersCount(),
			'fake' => $this->makeNUsers(),
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
		];

		return strtr($str, $transliteration);
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
		$us = $this->mainUsersMaker(); // us = users
		$this->showCount($us);
		$us = $this->replaceDuplicated($us);

		sort($us);

		$this->showCount($us);

		return $us;
	}

	private function showCount($us)
	{
		echo $this->nb . ' → Final: ' . count($us) . '<hr>';
	}

	private function replaceDuplicated($us)
	{
		$n = count($us);
		while ($n < $this->nb)
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
		for ($i = 0; $i < $this->nb; $i++)
		{
			// $us[] = $this->fakeUser();
			$us[] = $this->fakeName();
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
		// return fake()->firstNameFemale();
		$u            = new AcademyUser();
		$u->firstname = fake()->firstNameMale();
		$u->name      = fake()->lastName();
		$u->email     = $this->normalize(strtolower($u->firstname . '.' . $u->name)) . '@example.com';
		$u->role      = 'student';
		$u->valid     = true;

		// $u->save();
		return $u;
	}
};
