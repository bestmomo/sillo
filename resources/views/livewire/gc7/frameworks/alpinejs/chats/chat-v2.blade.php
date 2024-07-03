<?php
include_once 'chat-v2.php';
?>

<div>

    <div class="flex gap-4 items-center justify-around w-[150px]">
        <h1>V2</h1>
        <p><a class='link m-0 p-0 b-6' href="https://www.youtube.com/watch?v=BEKiNgcBqJw" target='_blank'
                title='Vidéo source'>(Source - 50')</a>
    </div>

    <ul>
        @foreach ($conversation as $thread)
            <li>{{ $thread['username'] }}: {{ $thread['message'] }}</li>
        @endforeach
    </ul>

    @php
        $sendIconColor = 'greenyellow';
    @endphp

    <form class="mt-2" wire:submit="submitMessage">
        <x-input wire:model="message" />
        <button class="btn btn-outline btn-primary my-3" type="submit">
            Send
            <x-icon-send color="{{ $sendIconColor }}" />
        </button>
    </form>

</div>
