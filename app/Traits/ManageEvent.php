<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Traits;

use Carbon\Carbon;

trait ManageEvent
{
	public string $label       = '';
	public string $description = '';
	public string $color       = 'red';
	public string $start_date  = '';
	public ?string $end_date   = null;
	public array $colors       = [];
	protected $rules           = [
		'label'       => 'required|string|max:50',
		'description' => 'required|max:200',
		'color'       => 'required|string',
		'start_date'  => 'required|date',
		'end_date'    => 'nullable|date',
	];

	/**
	 * Checks if the end date is at least one day after the start date.
	 *
	 * @return bool returns true if the end date is valid, false otherwise
	 */
	public function checkDates(): bool
	{
		// Convert dates to Carbon instances for better date handling
		$start_date = Carbon::parse($this->start_date);
		$end_date   = Carbon::parse($this->end_date);

		// Check if end_date is at least one day after start_date
		if ($this->end_date && !$end_date->isAfter($start_date)) {
			$this->error(__('End date must be after start date.'));

			return true;
		}

		return false;
	}

	/**
	 * Returns an array of color objects with their corresponding IDs and names.
	 *
	 * @return array an array of color objects with their corresponding IDs and names
	 */
	public function getColors(): array
	{
		$colors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'];

		$colorArray = [];
		foreach ($colors as $color) {
			$colorArray[] = ['id' => $color, 'name' => ucfirst($color)];
		}

		return $colorArray;
	}
}
