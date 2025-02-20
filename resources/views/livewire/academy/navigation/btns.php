<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Route;

function CssClass ($k)
{
	$currRoute = Route::currentRouteName();

	// $vars = "{$k} // {$currRoute}";
	// Debugbar::addMessage($vars, addslashes('$k // $currRoute'));

	return 0 === strpos( $currRoute, $k) ? 'text-green-400 disabled' : '';
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
		'routeLink' => 'academy.cases',
	],
	'Test' => [
		'title'     => 'Test rapide',
		'icon'      => 'o-beaker',
		'routeLink' => 'academy.test.in-progress',
	],
	'Académie2' => [
		'title'     => 'Accueil Académie',
		'icon'      => 'o-academic-cap',
		'routeLink' => 'academy.academy',
	],
	'Frameworks2' => [
		'title'     => 'Livewire & AlpineJS',
		'icon'      => 'o-building-library',
		'routeLink' => 'academy.frameworks',
	],
];

$btns = array_map(function($btn)
{
	$btn['css'] = CssClass($btn['routeLink']);

	return $btn;
}, $btns);

// Debugbar::info($btns);