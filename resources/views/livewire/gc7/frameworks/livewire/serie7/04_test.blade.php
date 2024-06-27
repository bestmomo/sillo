<?php
include_once '04_test.php';
?>

<div>
    @section('styles')
        <style>
            .drawer-content {
                padding: 0;
            }

            .btn-menu {
                color: #ccc;
                transition: .5s ease-in-out;
            }

            .btn-menu.active {
                font-weight: bold;
                color: orange;
            }

            .btn-menu:hover {
                color: #c7cf2f;
            }
        </style>
    @endsection
    {{-- <x-header class="mb-0 pt-3" title="Série 7 - Offset" shadow separator progress-indicator /> --}}
    <x-header class="mt-[-12px] px-0 w-[96%] mx-auto" shadow separator progress-indicator />

    <div class="px-5 mt-[-12px]">
        <div class="py-1 px-3 bg-white dark:bg-gray-800 text-white rounded">
            <p>Test</p>
            <table>
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                </thead>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->gender }}</td>
                    @empty
                        No users found
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
