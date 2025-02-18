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
foreach ($breakpoints as $i => $breakpoint)
{
	if (!$i)
	{
		$code .= ind() . "<div class=\"block sm:hidden text-xl\"><i><a title=\"oki\">{$breakpoint}</a></i></div>\n";
	}
	else
	{
		// $code .= ind() . "<div class='hidden text-" . ($i + 1) . "xl'>{$breakpoint}</div>\n";
		
		$code .= ind() . $i . ' ' . $breakpoint . "\n";
	}
}
$code .= "</div>\n";
// 	if ('xs' == $breakpoint)
// 	{
// 		echo '<div class="block sm:hidden text-xl"><i><a title=\"oki\"> ' . $breakpoint . '</a></i></div>';
// 	} 
// 	else
// 	{
// 		$classes = '';
// 		for ($j = 0; $j < $i; $j++)
// 		{
// 			$classes .= $breakpoints[$j] . ':hidden ';
// 		}
// 		$classes .= $breakpoint . ':block ';
// 		$classes .= 'text-' . ($i + 2) . 'xl';
// 		echo '<div class="hidden ' . $classes . '">' . $breakpoint . '</div>';
// 	}
// }

// echo '</div></pre>';

echo '<pre>' . htmlspecialchars($code) . '</pre>';

echo '<hr class="my-6"><pre>' . htmlspecialchars('
<div class="text-yellow-400 text-4xl z-10 font-bold">
	<div class="block sm:hidden text-xl"><i><a title="oki">xs</a></i></div>
	<div class="hidden sm:block md:hidden lg:hidden xl:hidden 2xl:hidden text-2xl">sm</div>
	<div class="hidden sm:hidden md:block lg:hidden xl:hidden 2xl:hidden text-3xl">md</div>
	<div class="hidden sm:hidden md:hidden lg:block xl:hidden 2xl:hidden text-4xl">lg</div>
	<div class="hidden sm:hidden md:hidden lg:hidden xl:block 2xl:hidden text-5xl">xl</div>
	<div class="hidden sm:hidden md:hidden lg:hidden xl:hidden 2xl:block text-6xl">2xl</div>
</div>
') . '</pre>';
