@php
	include '../resources/views/livewire/academy/navigation/btns.php';
@endphp

<x-nav sticky full-width class='flex flex-wrap'>

	<x-slot:brand class="mr-6">
		<div>
			<a class='font-new text-lg' href="{{ route('home') }}" title=" {{ __('Home') }} ">{{ __('Home') }}</a>
		</div>
	</x-slot:brand>

	<x-slot:actions>

		@foreach ($btns as $k => $btn)

			<x-button label="{{ $k }}" title="{{ $btn['title'] }}" icon="{{ $btn['icon'] }}"
				link="{{ route($btn['routeLink']) }}"
				@class(['btn-ghost btn-sm font-new text-lg', $btn['css']])
				responsive
				/>
		@endforeach

	</x-slot:actions>

</x-nav>
