<?php
include_once 'chat-v1.php';
?>

<div class="absolute top-16" wire:poll.5s>

    <ul>
        @foreach ($conversation as $thread)
            <li>{{ $thread['username'] }}: {{ $thread['message'] }}</li>
        @endforeach
    </ul>

    @php
        $sendIconColor = 'greenyellow';
    @endphp

    <form class="mt-2" wire:submit.prevent="submitMessage">
        <x-input wire:model="message" input="v1" />
        <button class="btn btn-outline btn-primary my-3" type="submit">
            Send
            <x-icon-send color="{{ $sendIconColor }}" />
        </button>
    </form>

</div>
