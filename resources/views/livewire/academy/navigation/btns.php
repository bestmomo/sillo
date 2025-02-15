<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Route;

function CssClass ($k)
{
	$currRoute = Route::currentRouteName();
	return $k == $currRoute ? 'text-white' : '';
}

$btns = [
	'Académie' => [
		'title'     => 'Accueil Académie',
		'icon'      => 'o-academic-cap',
		'routeLink' => 'academy.academy',
	],
	'Frameworks' => [
		'title'     => 'Livewire & AlpineJS',
		'icon'      => 'o-building-library',
		'routeLink' => 'academy.frameworks',
	],
	'Études' => [
		'title'     => 'Étude de Cas',
		'icon'      => 'o-wallet',
		'routeLink' => 'academy.tests',
	],
];

$btns = array_map(function($btn) {
    $btn['css'] = CssClass($btn['routeLink']);
    return $btn;
}, $btns);

Debugbar::info($btns);