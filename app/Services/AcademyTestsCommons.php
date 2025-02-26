<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

namespace App\Services;

use App\Models\AcademyUser;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\{DB, Schema};

class AcademyTestsCommons
{
	public CONST USERS_TEST_TABLE = 'academy_users_4_tests';

	public function getUsers4Tests($search)
	{
		// Schema::DROP(self::USERS_TEST_TABLE);

		if (!Schema::hasTable(self::USERS_TEST_TABLE))
		{
			$this->createTestUsersTable();
		}

		return DB::table(self::USERS_TEST_TABLE)
			->when($search, function ($query) use ($search)
			{
				$query->where('firstname', 'like', "%{$search}%");
			})
			// ->paginate(3, ['firstname', 'id']);
			->paginate(3, ['firstname']);
	}

	public function createTestUsersTable()
	{
		$u0 = AcademyUser::find(1) ?? null;
		if ($u0)
		{
			$u0->id = 888;
			$u0->save();
		}

		Debugbar::addMessage('Création de la table ' . self::USERS_TEST_TABLE . ' - ' . now(), 'Test commons');
		DB::statement('CREATE TABLE ' . self::USERS_TEST_TABLE . ' AS SELECT * FROM academy_users');

		$u0 = AcademyUser::find(888) ?? null;
		if ($u0)
		{
			$u0->id = 1;
			$u0->save();
		}

		$usersAll = DB::table(self::USERS_TEST_TABLE)->get();
		$i        = 1;
		foreach ($usersAll as $u)
		{
			$oldId = $u->id;
			$u->id = $i++;
			DB::table(self::USERS_TEST_TABLE)->where('id', $oldId)->update(['id' => $u->id]);
		}

		$u1    = DB::table(self::USERS_TEST_TABLE)->find(1);
		$uLast = DB::table(self::USERS_TEST_TABLE)->get()->last();

		dump($u1, $uLast);
	}
}
