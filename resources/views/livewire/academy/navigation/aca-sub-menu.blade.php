@php
	include '../resources/views/livewire/academy/navigation/btns.php';
@endphp

<x-nav sticky full-width class='flex flex-wrap'>

	<x-slot:brand>
		<div>
			<a href="{{ route('admin') }}" title=" {{ __('Dashboard') }} ">{{ __('Home') }}</a>
		</div>
	</x-slot:brand>

	<x-slot:actions>

		@foreach ($btns as $k => $btn)
			{{-- @php
			preg_match('/[^.]+$/', $btn['link'], $matches);
			$route_last_segment = $matches[0];
			@endphp --}}

			<x-button label="{{ $k }}" title="{{ $btn['title'] }}" icon="{{ $btn['icon'] }}"
				link="{{ route($btn['routeLink']) }}" {{-- @class(['btn-ghost btn-sm', 'btn-disabled !text-white'=>
				Route::currentRouteName() == $route_last_segment]) --}}
				@class(['btn-ghost btn-sm', $btn['css']])
				responsive
				/>
		@endforeach

			{{-- <x-button label="Académie" title="Accueil Académie" icon="o-academic-cap"
				link="{{ route('academy.academy') }}" @class(['btn-ghost btn-sm', 'btn-disabled !text-white'=>
				Route::currentRouteName() == 'academy.academy'])
				responsive />

				<x-button label="Frameworks" title="Livewire & AlpineJS" icon="o-building-library"
					link="{{ route('academy.frameworks') }}" class="btn-ghost btn-sm active" responsive />

				<x-button label="Études" title="Étude de Cas" icon="o-wallet" link="{{ route('academy.tests') }}"
					class="btn-ghost btn-sm active" responsive /> --}}

	</x-slot:actions>

</x-nav>
