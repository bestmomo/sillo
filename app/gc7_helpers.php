<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Volt\Volt;

if (!function_exists('getGc7FrameworksLinks')) {
	function getGc7FrameworksLinks($src = 'web')
	{
		$frameworksLinks = [
			'livewire' => ['basics', 'blog', 'create-post', 'todos', 'counter', 'new-form'],
			'alpinejs' => ['basics', 'test'],
		];

		echo '<ul>';
		foreach ($frameworksLinks as $framework => $links) {
			// echo '<li>' . ucfirst($framework) . '</li>';

			echo '<ul>';
			foreach ($links as $link) {
				// echo '<li>- ' . ucfirst($link) . '</li>';

				// echo "/{$framework}/{$link} -> /{$framework}/{$link} <br>";
				Volt::route("/{$framework}/{$link}", "/{$framework}/{$link}");
			}

			echo '</ul>';
		}
		echo '</ul>';
		echo $framework;
		echo $link;
		Volt::route('/livewire/blog', 'gc7.frameworks.livewire.blog');
		// return [
		// ];
	}
}
