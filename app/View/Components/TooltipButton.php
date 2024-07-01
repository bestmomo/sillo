<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\View\Components;

use Illuminate\View\Component;

class TooltipButton extends Component
{
	public $icon;
	public $action;
	public $tooltip;
	public $confirm;
	public $class;

	public function __construct($icon, $action, $tooltip, $confirm = null, $class = '')
	{
		$this->icon    = $icon;
		$this->action  = $action;
		$this->tooltip = $tooltip;
		$this->confirm = $confirm;
		$this->class   = $class;
	}

	public function render()
	{
		return view('components.tooltip-button');
	}
}
