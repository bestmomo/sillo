<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class() extends Component {
	use WithPagination;

	public $name;
	public $subtitle = 'Offset';
	public $offset   = 0;
	public $limit    = 15;
	public $users;
	public $loadMore;
	public $search        = '';
	public $sortColumn    = 'id';
	public $sortDirection = 'ASC';

	public function mount($loadMore = true, $offset = 0)
	{
		$this->name = 'GC7';
		if (0 == $offset) {
			$this->dispatch('update-subtitle', newSubtitle: $this->subtitle);
			logger('Dispatching update-subtitle event');
		}

		$this->loadMore = $loadMore;
		$this->offset   = $offset;
	}

	public function doSort($column)
	{
		$this->sortColumn = $column;
		if ($this->sortColumn === $column) {
			$this->sortDirection = 'ASC' == $this->sortDirection ? 'DESC' : 'ASC';

			return;
		}
		$this->sortColumn    = $column;
		$this->sortDirection = 'ASC';
	}

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function with(): array
	{
		if ($this->loadMore) {
			$this->users = User::offset($this->offset)
				->orderBy($this->sortColumn, $this->sortDirection)
				->search($this->search)
				->limit($this->limit)
				->get();
		}

		return [
			'users' => $this->users,
		];
	}
}; ?>

<div>

    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Infinite Scroll" shadow separator progress-indicator /> --}}
    {{-- <x-header class="m-0 p-0" shadow separator progress-indicator /> --}}

    {{-- <section class="mt-5"> --}}
    @if ($offset == 0)
        <section class="mt-3">
            <div class="max-auto max-w-screen-3xl px-4 lg:px-12 mx-auto">
                <div class="bg-white dark:bg-gray-800 overflow-hidden">
                    <div class="flex items">
                        <div class="max-auto w-full px-4 lg:px-12">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden">
                                <div class="flex items-center justify-between my-4">
                                    <div class="flex w-5/6 justify-between items-center">
                                        <div class="relative x-full">
                                            <x-input type="text" class="bg-gray-700 border border-gray-300"
                                                wire:model.live.debounce.300ms="search" placeholder="Search..."
                                                required />
                                        </div>
                                        <div class="flex items-center justify-end">
                                            <span class="italic">Owner:</span>
                                            <x-heroicon-s-heart class="h-6 w-6 text-red-600 mx-2" />
                                            <span>{{ $name }}</span>
                                        </div>

                                    </div>
                                </div>
    @endif
    @if ($loadMore)
        <div class="overflow-x-auto rounded">
            <table class="w-full text-sm text-left text-gray-500">
                @if ($offset % 50 == 0)
                    <thead class="text-xs text-gray-400 uppercase">
                        <tr>

                            <th class="w-1/12 py-3 cursor-pointer pl-[50px] sm:px-0" wire:click="doSort('id')">
                                <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="id"
                                    scope="col" />
                            </th>

                            <th class="w-4/12 px-2 py-3 cursor-pointer" wire:click="doSort('name')">
                                <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="name"
                                    scope="col" />
                            </th>

                            <th class="w-5/12 px-2 py-3 cursor-pointer" wire:click="doSort('email')">
                                <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email"
                                    scope="col" />
                            </th>

                            <th class="w-2/12 px-2 py-3 cursor-pointer" wire:click="doSort('gender')">
                                <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="gender"
                                    scope="col" />
                            </th>

                        </tr>
                    </thead>
                @endif
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b dark:border-gray-700">

                            <td class="w-1/12 px-2 py-2 text-right lg:pr-[50px] sm:pr-5">{{ $user->id }}</td>

                            <td class="w-4/12 px-2 py-2 whitespace-nowrap overflow-hidden text-ellipsis">
                                <div class="w-1/4 flex items-center space-x-1">
                                    <span class="font-medium">{{ $user->name }}</span>
                                    <span>{{ $user->firstname }}</span>
                                </div>
                            </td>

                            <td class="w-5/12 px-2 py-2">{{ $user->email }}</td>

                            <td class="w-2/12 px-2 py-2">{{ $user->gender }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-3" colspan="4">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @livewire('academy.frameworks.livewire.serie7.03_offset', ['loadMore' => false, 'offset' => $offset + $limit], key($offset))
    @else
        <div class="flex gap-3 mt-3">
            <button wire:click="$set('loadMore', true)" class="btn btn-primary mt-0 mb-5 p-0 text-xs w-1/6">Load
                more</button>
            <div class="w-full">
                <x-header class="!m-0 !p-0" id="myHeader" separator progress-indicator></x-header>
            </div>
        </div>
    @endif
    @if ($offset == 0)
</div>


{{-- <div x-intersect="$wire.loadMore()" class="border-4 h-60">
    Load more by scrolling
</div> --}}
{{-- <div x-intersect="$wire.loadMore()" class="h-60"></div> --}}
</div>
</section>
@endif
</div>
