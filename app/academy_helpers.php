<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Livewire\Volt\Volt;
use Barryvdh\Debugbar\Facades\Debugbar;

if (!function_exists('getAcademyFrameworksLinks'))
{
	function getAcademyFrameworksLinks()
	{
		
		//2do suppr chats en production
		return [
			'livewire' => ['basics', 'blog', 'create-post', 'new-form', 'email', 'todos', 'counter', 'serie7', 'users'],
			'alpinejs' => ['basics', 'test', 'pets', 'accordion', 'ga', 'characters', 'drag-drop', 'chats', 'kanboard', 'divers'],
		];
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
					Volt::route("/{$framework}/{$link}", 
						"academy.dpts.frameworks.{$framework}.{$link}")->name("academy.frameworks.{$framework}.{$link}");
				// }
			}
		}
	}
}
