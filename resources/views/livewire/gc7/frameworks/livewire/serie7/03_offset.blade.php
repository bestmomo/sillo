<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $name;
    public $subtitle = 'Offset';

    public $offset = 0;
    public $limit = 10;
    public $users;
    public $loadMore;

    public $search = '';
    public $sortColumn = 'id';
    public $sortDirection = 'ASC';

    public function mount($loadMore = true, $offset = 0)
    {
        $this->name = 'GC7';
        if ($offset == 0) {
            $this->dispatch('update-subtitle', newSubtitle: $this->subtitle);
            logger('Dispatching update-subtitle event');
        }

        $this->loadMore = $loadMore;
        $this->offset = $offset;
    }

    public function doSort($column)
    {
        $this->sortColumn = $column;
        if ($this->sortColumn === $column) {
            $this->sortDirection = 'ASC' == $this->sortDirection ? 'DESC' : 'ASC';

            return;
        }
        $this->sortColumn = $column;
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

    @php
        $users = $this->users;
    @endphp
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Infinite Scroll" shadow separator progress-indicator /> --}}
    <x-header class="mb-0 mt-[-12px]" shadow separator progress-indicator />

    <section class="mt-5">
        <div class="max-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden">
                <div class="flex items-center justify-between p-4 my-2">
                    <div class="flex w-full justify-between items-center">
                        <div class="relative x-full ml-3">
                            <x-input type="text" class="bg-gray-700 border border-gray-300"
                                wire:model.live.debounce.300ms="search" placeholder="Search..." required />
                        </div>
                        <p class="flex items-center justify-end mr-5 italic">
                            <span>Owner:</span>
                            <x-heroicon-s-heart class="h-6 w-6 text-red-600 mx-2" />
                            <span>{{ $name }}</span>
                        </p>

                    </div>
                </div>

                @if ($loadMore)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 rounded">
                            @if ($offset % 50 == 0)
                                <thead class="text-xs text-gray-400 uppercase">
                                    <tr>

                                        <th class="px-4 py-3 cursor-pointer" wire:click="doSort('id')">
                                            <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                                columnName="id" scope="col" />
                                        </th>

                                        <th class="px-4 py-3 cursor-pointer" wire:click="doSort('name')">
                                            <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                                columnName="name" scope="col" />
                                        </th>

                                        <th class="px-4 py-3 cursor-pointer" wire:click="doSort('email')">
                                            <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                                columnName="email" scope="col" />
                                        </th>

                                        <th class="px-4 py-3 cursor-pointer" wire:click="doSort('gender')">
                                            <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                                columnName="gender" scope="col" />
                                        </th>

                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $user->id }}</td>
                                        <td class="px-4 py-3">
                                            {{ $user->name }}
                                            {{ $user->firstname }}
                                        </td>
                                        <td class="px-4 py-3">{{ $user->email }}</td>
                                        <td class="px-4 py-3">{{ $user->gender }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-3" colspan="4">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @livewire('gc7.frameworks.livewire.serie7.03_offset', ['loadMore' => false, 'offset' => $offset + $limit], key($offset))
                @else
                    <button wire:click="$set('loadMore', true)" class="btn btn-primary">LoadMore</button>
                @endif

            </div>

            <x-header class="mt-0" separator progress-indicator></x-header>

            {{-- <div x-intersect="$wire.loadMore()" class="border-4 h-60">
                Load more by scrolling
            </div> --}}
            {{-- <div x-intersect="$wire.loadMore()" class="h-60"></div> --}}
        </div>
    </section>
</div>
