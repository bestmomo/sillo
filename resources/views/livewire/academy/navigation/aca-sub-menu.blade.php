@php
    include '../resources/views/livewire/academy/navigation/btns.php';
@endphp

{{-- <x-nav sticky full-width class='flex w-full !justify-items-stretch !my-0 !py-0 border border-blue-500 gap-0'> --}}
<x-nav sticky full-width class='!my-0 !py-0 border border-blue-500 gap-0'>

    <x-slot:brand class="w-[10%] mr-6 border border-red-500 !p-0 !m-0">
        <div>
            <a class='font-shadow text-2xl text-gray-300 tracking-wider' href="{{ route('home') }}"
                title=" {{ __('Public Home') }} ">{{ strtoupper(__('Home')) }}</a>
        </div>
    </x-slot:brand>

    <x-slot:actions class="border-2 border-green-500 flex justify-between flex-wrap !p-0">
		
			<div class="w-full border border-white flex flex-wrap justify-center items-center !p-0">
				
				@foreach ($btns as $k => $btn)
					<x-button label="{{ $k }}" title="{{ $btn['title'] }}" icon="{{ $btn['icon'] }}"
				link="{{ route($btn['routeLink']) }}" @class(['btn-ghost btn-sm font-new text-lg', $btn['css']]) responsive />
        @endforeach
				
        {{-- @if (auth()->user()->isAdmin()) --}}
				{{-- <x-slot:actions> --}}
					<x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline font-new"
					link="{{ route('admin') }}" />
					{{-- </x-slot:actions> --}}
					{{-- @endif --}}
					
				</div>
			</x-slot:actions>

</x-nav>
