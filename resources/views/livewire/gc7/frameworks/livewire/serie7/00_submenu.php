<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Livewire\Volt\Component;

new class() extends Component {
	public $btns = [
		'Users',
		'Infinite_Scroll',
		'Offset',
	];
	public $choice;
	public $subtitle = 'aaa';

	protected $listeners = ['update-subtitle' => 'updateSubtitle'];
	
	    public function updateSubtitle($newSubtitle)
    {
        $this->subtitle = $newSubtitle;
    }
		
	public function setChoice($btn)
	{
		$this->choice = $btn;
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
