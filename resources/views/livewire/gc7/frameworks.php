<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Volt\Volt;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new
#[Title('Frameworks')]
#[Layout('components.layouts.gc7.main')]
class extends Component {
	// public $frameworksLinks=[];

	public function mount()
	{
		// $frameworksLinks = [
		// 	'livewire' => ['basics', 'blog', 'create-post', 'todos', 'counter', 'new-form'],
		// 	'alpinejs' => ['alpine', 'test'],
		// ];

		// echo '<ul>';
		// foreach ($frameworksLinks as $framework => $links) {
		// 	// echo '<li>' . ucfirst($framework) . '</li>';

		// 	echo '<ul>';
		// 	foreach ($links as $link) {
		// 		echo '<li>- ' . ucfirst($link) . '</li>';
		// 		Volt::route('/', 'gc7.abc.aaa_test');
		// 	}

		// 	echo '</ul>';
		// }
		// echo '</ul>';
	}
};
