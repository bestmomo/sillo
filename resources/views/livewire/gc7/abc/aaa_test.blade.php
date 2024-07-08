<?php

use App\Models\User;
include_once 'aa_test.php';
?>
<div>
    <x-header class="mb-0" title="Test" shadow separator progress-indicator />

    <h1>Ready.</h1>

    <hr>

    <div class="my-3 font-bold text-xl">Users :</div>

    <table class="w-1/2 mx-auto">
        @foreach ($roleCounts as $role => $count)
            <tr class="!border-0">

                <td class="border-b-gray-500 pl-3">{{ ucfirst($role) }}</td>
                <td class="text-right border-b-gray-500 pr-7">{{ $count }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="border-0"></td>
            <td class="text-right font-bold border-0 pr-7">{{ $nbrUsers }}</td>
        </tr>
    </table>

    {{-- {{ $users->pluck('name', 'role')->join(', ') }} --}}

    {{-- @livewire('uuu2') --}}
</div>
