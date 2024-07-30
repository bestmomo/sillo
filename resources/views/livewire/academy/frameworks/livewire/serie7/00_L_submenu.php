<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Livewire\Volt\Component;

new class() extends Component {
	public $btns;
	public $choice;
	public $component;

	public function setChoice($btn)
	{
		$this->choice    = $btn;
		$this->component = $this->getComponentName($btn);
	}

	public function getComponentName($choice): ?string
	{
		$index = array_search($choice, $this->btns);

		if (false !== $index) {
			$formattedIndex  = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
			$lowercaseChoice = strtolower($choice);

			return "{$formattedIndex}_{$lowercaseChoice}";
		}

		return null;
	}

	// protected function onSetSubtitle($subtitle)
	// {
	// 	$this->subtitle = $subtitle;
	// }
};
