<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

return [
	'config' => [
		'language'       => env('APP_TINYMCE_LOCALE', 'en_US'),
		'plugins'        => 'codesample fullscreen',
		'toolbar'        => 'undo redo style | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | copy cut paste pastetext | hr | codesample | link image quicktable | fullscreen',
		'toolbar_sticky' => true,
		'min_height'     => 1000,
		'license_key'    => 'gpl',
		'valid_elements' => '*[*]',
	],
	'config_comment' => [
		'language'       => env('APP_TINYMCE_LOCALE', 'en_US'),
		'plugins'        => 'codesample',
		'toolbar'        => 'undo redo | styles | copy cut paste pastetext | hr | codesample',
		'toolbar_sticky' => true,
		'min_height'     => 300,
		'license_key'    => 'gpl',
	],
];
