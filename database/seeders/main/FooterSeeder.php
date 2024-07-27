<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace database\seeders\main;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        // Données des éléments du pied de page
        $footers = [
            ['label' => 'Accueil', 'order' => 1, 'link' => '/'],
            ['label' => 'Terms', 'order' => 3, 'link' => '/pages/terms'],
            ['label' => 'Policy', 'order' => 4, 'link' => '/pages/privacy-policy'],
            ['label' => 'Contact', 'order' => 5, 'link' => '/contact'],
        ];

        // Insérer les données dans la table footers
        DB::table('footers')->insert($footers);
    }
}
