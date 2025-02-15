@php
	include '../resources/views/livewire/academy/navigation/btns.php';
@endphp

<x-nav sticky full-width class='flex flex-wrap'>

	<x-slot:brand class="mr-6">
		<div>
			<a href="{{ route('admin') }}" title=" {{ __('Dashboard') }} ">{{ __('Home') }}</a>
		</div>
	</x-slot:brand>

	<x-slot:actions>

		@foreach ($btns as $k => $btn)

			<x-button label="{{ $k }}" title="{{ $btn['title'] }}" icon="{{ $btn['icon'] }}"
				link="{{ route($btn['routeLink']) }}" {{-- @class(['btn-ghost btn-sm', 'btn-disabled !text-white'=>
				Route::currentRouteName() == $route_last_segment]) --}}
				@class(['btn-ghost btn-sm', $btn['css']])
				responsive
				/>
		@endforeach

	</x-slot:actions>

</x-nav>
