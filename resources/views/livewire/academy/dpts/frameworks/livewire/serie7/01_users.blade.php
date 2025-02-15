<?php
include_once '01_users.php';
?>

<div>

    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Users" shadow separator progress-indicator /> --}}
    <x-header class="mb-0 mt-[-12px]" shadow separator progress-indicator />

    <section class="mt-5">
        <div class="max-auto max-w-screen-3xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 overflow-hidden">
                <div class="flex items-center justify-between p-4 my-2">
                    <div class="flex w-full justify-between items-center gap-2">
                        <div class="flex-shrink-0 whitespace-nowrap">
                            Page {{ $paginator['current'] }} / {{ $paginator['last'] }}
                        </div>
                        <div class="relative flex-grow mx-3">
                            <x-input type="text" class="bg-gray-700 border border-gray-300"
                                wire:model.live.debounce.300ms="search" placeholder="Search..." required />
                        </div>
                        <p class="flex-shrink-0 flex items-center justify-end italic text-sm">
                            <span>(Student color cyan)</span>
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
                                <tr wire:key="user-{{ $user->id }}"
                                    class="{{ $user->isStudent ? 'text-cyan-500' : '' }}"
                                    class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">{{ $user->id }}</td>
                                    <td class="px-4 py-3 ">
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
                <div class="py-4 px-3">
                    <div class="flex space-x-4 iems-center mb-3">
                        <labelfor="PerPage">Per Page</labelfor=>
                        <select class="ml-4" wire:model.live="perPage" name="" id="">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex flex-wrap">
                        {{ $users->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
