<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}',
//  function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel(
	'messages',
	function () {
		return true;
	}
);
