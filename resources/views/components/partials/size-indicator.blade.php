<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

$breakpoints = ['xs', 'sm', 'md', 'lg', 'xl', '2xl'];

$code = "<div class=\"text-yellow-500 text-4xl z-10 font-bold\">\n";

function ind() // indentation
{
	return str_repeat(' ', 4);
}

$brks = [];
foreach (array_slice($breakpoints, 1) as $brk) {
	$brks[$brk] = 'hidden';
}

foreach ($breakpoints as $i => $breakpoint) {
	if (!$i) {
		$code .= ind() . "<div class=\"block sm:hidden text-xl\"><i><a title=\"Is not a real TailwindCSS 's breakpoint\">{$breakpoint}</a></i></div>\n";
	} else {
		$bsInCode = '';
		foreach ($brks as $k => $j) {
			$brks[$breakpoint] = 'block';
			$bsInCode .= $k . ':' . $brks[$k] . ' ';
			$brks[$breakpoint] = 'hidden';
		}
		;

		$code .= ind() . "<div class='hidden " . $bsInCode . 'text-' . ($i + 1) . "xl'>{$breakpoint}</div>\n";
		// $code .= ind() . $i . ' ' .$bsInCode.' '. $breakpoint . "\n";
	}
}
$code.='</div>';

echo $code;

// echo '<b>Code issu du script</b><br>';
// echo '<pre>' . htmlspecialchars($code) . '</pre>';

// echo '<hr class="my-6"><b>Code généré</b><br><pre>' . htmlspecialchars('
// <div class="text-yellow-400 text-4xl z-10 font-bold">
// 	<div class="block sm:hidden text-xl"><i><a title="Is not a real TailwindCSS \'s breakpoint">xs</a></i></div>
// 	<div class="hidden sm:block md:hidden lg:hidden xl:hidden 2xl:hidden text-2xl">sm</div>
// 	<div class="hidden sm:hidden md:block lg:hidden xl:hidden 2xl:hidden text-3xl">md</div>
// 	<div class="hidden sm:hidden md:hidden lg:block xl:hidden 2xl:hidden text-4xl">lg</div>
// 	<div class="hidden sm:hidden md:hidden lg:hidden xl:block 2xl:hidden text-5xl">xl</div>
// 	<div class="hidden sm:hidden md:hidden lg:hidden xl:hidden 2xl:block text-6xl">2xl</div>
// </div>
// ') . '</pre>';
