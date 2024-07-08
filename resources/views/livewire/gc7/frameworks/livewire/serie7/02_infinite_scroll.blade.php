<?php
include_once '02_infinite-scroll.php';
?>

<div>
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Infinite Scroll" shadow separator progress-indicator /> --}}
    <x-header class="mb-0 mt-[-12px]" shadow separator progress-indicator />

    <section class="mt-5">
        <div class="max-auto max-w-screen-3xl px-4 lg:px-12">
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

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 rounded">
                        <thead class="text-xs text-gray-400 uppercase">
                            <tr>

                                <th class="px-4 py-3 cursor-pointer" wire:click="doSort('id')">
                                    <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="id" />
                                </th>

                                <th class="px-4 py-3 cursor-pointer" wire:click="doSort('name')">
                                    <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                        columnName="name" />
                                </th>

                                <th class="px-4 py-3 cursor-pointer" wire:click="doSort('email')">
                                    <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                        columnName="email" />
                                </th>

                                <th class="px-4 py-3 cursor-pointer" wire:click="doSort('gender')">
                                    <x-users-list.datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                        columnName="gender" />
                                </th>

                            </tr>
                        </thead>
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
            </div>
            
            <x-header class="mt-0" separator progress-indicator></x-header>

            {{-- <div x-intersect="$wire.loadMore()" class="border-4 h-60">
                Load more by scrolling
            </div> --}}
            <div x-intersect="$wire.loadMore()" class="h-60"></div>
        </div>
    </section>
</div>
