<?php
include_once 'faker.php';
?>

<div>
    {{-- @dump($fakes) --}}
    <style>
        th,
        td {
            border: 1px solid black;
            padding: 2px 10px;
        }
    </style>
    {{-- <h2>{{ $var }} users, dont :</h2> --}}
    <table class='mt-3'>

        <thead>
            <tr>

                <th>Id</th>
                <th>IdDb</th>
                <th>Civilité</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Genre</th>
                <th>Parr</th>
                <th>Email</th>
                {{-- <th>Académie</th> --}}
                <th>Rôle</th>
                {{-- <th>PassWord</th>
                <th>Remember TK</th> --}}
                <th>Created_at</th>
                <th>Updated_at</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr
                    class="space-x-2 gap-2 {{ $user->role === 'student' ? 'text-cyan-500' : ($user->role === 'tutor' ? 'text-red-500' : '') }}">
                    <td class='text-right'>{{ $loop->iteration }}</td>
                    <td class='text-right'>{{ $user->id }}</td>
                    <td>{{ $user->gender == 'female' ? 'Mme' : 'M' }}.</td>
                    <td>{{ $user->firstname }}</td>
                    <td>{{ strtoupper($user->name) }}</td>
                    <td class='text-center'>{{ $user->gender === 'male' ? 'H' : 'F' }}.</td>
                    <td class='text-center'>{{ $user->parr ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                    {{-- <td class='text-center'>{{ $user->academyAccess ? 'Oui' : 'Non' }}</td> --}}
                    <td>{{ mb_ucfirst($user->role === 'student' ? 'étudiant' : ($user->role === 'tutor' ? 'tuteur' : 'aucun')) }}
                    </td>
                    {{-- <td>{{ $user->password }}</td>
                    <td>{{ $user->remember_token }}</td> --}}
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                </tr>
            @empty
                <p>No users found</p>
            @endforelse
        </tbody>
    </table>
</div>
