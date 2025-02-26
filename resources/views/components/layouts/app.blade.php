<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{!! (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') !!}</title>

		<meta name="description" content="@yield('description')">
		<meta
		name="keywords" content="@yield('keywords')">

		@vite(['resources/css/app.css', 'resources/js/app.js'])

		<link rel="stylesheet" href="{{ asset('storage/css/prism.css') }}">

		@php
			$isHomePage = request()->is('/') || Str::startsWith(request()->fullUrl(), url('/?page='));
		@endphp

		@if(request()->is('surveys/show/*'))
			<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
		@elseif ($isHomePage)
			<script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.js"></script>
			<link
			href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.css" rel="stylesheet">
		@endif
	</head>

	<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
		{{-- HERO --}}
		<div class="min-h-[35vw] hero" style="background-image: url({{ asset('storage/hero.jpg') }});">
			<div class="bg-opacity-60 hero-overlay"></div>

			{{-- <x-partials.size-indicator/> --}}

			<a href="{{ '/' }}">
				<div class="text-center hero-content text-neutral-content flex justify-center">

					{{-- Ci-dessous, si on veut optimiser encore cet affichage, le partial size-indicator est juste
					à décommenter, et les cadres des élements sont laissés.. Mettre border-2 partout pour les voir. --}}
					<div class="flex flex-col justify-center items-center border-0 border-blue-400
							
						{{-- sm:w-[500px]
						md:w-[500px] --}}
						lg:w-[520px]
						xl:w-[530px]
						2xl:w-[550px]

						mx-auto">


						<div class="border-0 border-white w-full h-3/6">

							<div class='border-0 border-cyan-500 flex justify-center gap-6 items-center px-auto w-auto'>

								<x-icon-laravelmark class='border-0 text-center border-red-500 w-2/12 h-full'/>

								<h1 class="!font-shadow border-0 border-green-500">
									<div style="font-size: clamp(1rem, 7vw, 7rem);" class='pb-2 text-[#ff2d20] text-left tracking-wider'>{{ strtoupper(config('app.title')) }}
									</div>
								</h1>

							</div>

						</div>

						<div class="font bold text-center mb-5 text-[12px] sm:text-md md:text-xl lg:text-2xl xl:text-3xl text-[#ccc] tracking-wider">{{ config('app.subTitle') }}
						</div>

					</div>

				</div>
			</a>
		</div>

		{{-- NAVBAR --}}
		<livewire:navigation.navbar :$menus/>

		{{-- MAIN --}}
		<x-main full-width>

			{{-- SIDEBAR --}}
			<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit lg:hidden">
				<livewire:navigation.sidebar :$menus/>
			</x-slot:sidebar>

			{{-- SLOT --}}
			<x-slot:content>
				{{ $slot }}
			</x-slot:content>

		</x-main>

		{{-- FOOTER --}}
		<hr><br>
		<livewire:navigation.footer/>
		<br>

		{{--  TOAST area --}}
		<x-toast/>

		<script src="{{ asset('storage/scripts/prism.js') }}"></script>

		<script>
			document.addEventListener('prism-highlight', (e) => { // Wait a short moment to ensure DOM is updated
setTimeout(() => { // Select all pre and code elements in the post content
const codeBlocks = document.querySelectorAll('.prose pre, .prose code');
// Manually highlight each code block
codeBlocks.forEach(block => {
Prism.highlightElement(block);
});
}, 100);
});
		</script>

	</body>

</html>

