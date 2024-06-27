<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Volt\Component;

new class() extends Component {
	public $btns;
	public $choice;
	public $component;

	public function setChoice($btn)
	{
		$this->choice = $btn;
		$this->component = $this->getComponentName($btn);
	}

	public function getComponentName($choice): string
	{
		return strtolower($this->choice);
	}

	// protected function onSetSubtitle($subtitle)
	// {
	// 	$this->subtitle = $subtitle;
	// }
};
