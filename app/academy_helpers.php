<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Volt\Volt;

if (!function_exists('getAcademyFrameworksLinks'))
{
	function getAcademyFrameworksLinks()
	{
		// Supprimer 'chats' de la liste des liens pour alpinejs en production
		$links = [
			'livewire' => ['basics', 'blog', 'create-post', 'new-form', 'email', 'todos', 'counter', 'serie7', 'users'],
			'alpinejs' => ['basics', 'test', 'pets', 'accordion', 'ga', 'characters', 'chats', 'drag-drop', 'kanboard', 'divers'],
		];

		Debugbar::addMessage(config('app.env'), 'env');
		if (!'dev' === config('app.env'))
		{
			unset($links['alpinejs'][array_search('chats', $links['alpinejs'])]);
		}

		return $links;
	}
}

if (!function_exists('getAcademyFrameworksRoutes'))
{
	function getAcademyFrameworksRoutes()
	{
		$frameworksLinks = getAcademyFrameworksLinks();

		Debugbar::info($frameworksLinks);

		foreach ($frameworksLinks as $framework => $links)
		{
			foreach ($links as $link)
			{
				// if ('chats' !== $link)
				// {
				Volt::route(
					"/{$framework}/{$link}",
					"academy.dpts.frameworks.{$framework}.{$link}"
				)->name("academy.frameworks.{$framework}.{$link}");
				// }
			}
		}
	}
}
