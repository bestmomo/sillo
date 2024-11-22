<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component {
	/**
	 * Create a new component instance.
	 */
	public function __construct() {
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|\Closure|string {
		return <<<'HTML'
			    <a href="/" wire:navigate>
			        <!-- Hidden when collapsed -->
			        <div {{ $attributes->class(['hidden-when-collapsed']) }}>
			            <div class="flex items-center gap-2">
			                <x-icon name="o-square-3-stack-3d" class="w-6 -mb-1 text-purple-500" />
			                <span class="mr-3 text-3xl font-bold text-transparent bg-gradient-to-r from-purple-500 to-pink-300 bg-clip-text ">
			                    app
			                </span>
			            </div>
			        </div>

			        <!-- Display when collapsed -->
			        <div class="display-when-collapsed hidden mx-5 mt-4 lg:mb-6 h-[28px]">
			            <x-icon name="s-square-3-stack-3d" class="w-6 -mb-1 text-purple-500" />
			        </div>
			    </a>
			HTML;
	}
}
