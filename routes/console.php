<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function ()
{
	$this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
