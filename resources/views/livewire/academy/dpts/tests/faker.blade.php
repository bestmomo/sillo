<?php
include_once 'faker.php';
?>

<div>
    @dump($fake)

    {{-- <h2>{{ $var }} users, dont :</h2> --}}
    {{-- <ul>
        @forelse($users as $user)
            <li>- {{ $user->firstname }}</li>
        @empty
            <p>No users found</p>
        @endforelse
    </ul> --}}
</div>
