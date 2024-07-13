<?php
include_once 'users-table.php';
?>
<div>
    {{-- <x-card class="!p-0" title="Table:" shadow separator /> --}}

    <div class="field">
        <p class="control has-icons-left has-icons-right">
            <x-input type="email" placeholder="Rechercher un membre" class="input mb-2" icon="o-magnifying-glass" />
        </p>
    </div>
    @php
        $user = $users[0];
    @endphp
    <table class="table is-fullwidth has-text-grey">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Title</th>
                <th>Role</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>1</td>
                    <td>
                        <span class="font-bold">
                            {{ $user->name }} {{ $user->firstname }}
                        </span><br>
                        {{ $user->email }}

                    </td>
                    <td><span class="font-bold mr-2">
                            {{ ucfirst($user->role) }}
                        </span>

                    </td>

                    <td>
                        @if ($user->isStudent)
                            <x-icon name="o-academic-cap" class="w-7 h-7 text-cyan-400" />
                        @else
                            <x-icon name="o-user" class="w-7 h-7 text-gray-400" />
                        @endif
                    </td>

                    <td>
                        @if ($user->valid)
                            <x-icon-check />
                        @else
                            <x-icon-novalid />
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    @foreach ($users as $user)
        {{ $loop->iteration }} : {{ $user->firstname }}<br>
    @endforeach

</div>
