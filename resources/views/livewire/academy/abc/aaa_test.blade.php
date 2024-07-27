<?php
include_once 'aa_test.php';
?>
<div>
    <x-header class="mb-0" title="Test" shadow separator progress-indicator />

    <h1>Ready.</h1>

    <hr>

    <div class="my-3 font-bold text-xl">Users (1 DB request) :</div>

    <table class="w-full max-w-52 mx-auto">
        <thead>
            <th class="rounded-tl-lg">Role</th>
            <th>Student</th>
            <th class="rounded-tr-lg">Total</th>
        </thead>
        <tbody>
            @foreach ($roleCounts as $role => $count)
                <tr class="!border-0">
                    <td class="border-b-gray-500 pl-3">{{ ucfirst($role) }}</td>
                    <td class="text-right border-b-gray-500 pr-7">{{ $studentCounts[$role] ?? 0 }}</td>
                    <td class="text-right border-b-gray-500 pr-7">{{ $count }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="border-0 font-bold"></td>
                <td class="text-right font-bold border-0 pr-7">{{ $studentsCount }}</td>
                <td class="text-right font-bold border-0 pr-7">{{ $usersCount }}</td>
            </tr>
        </tbody>
    </table>

    {{-- {{ $users->pluck('name', 'role')->join(', ') }} --}}

    {{-- @livewire('uuu2') --}}
</div>
