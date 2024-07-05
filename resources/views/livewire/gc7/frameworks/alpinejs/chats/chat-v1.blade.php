<?php
include_once 'chat-v1.php';
?>

{{-- <div class="absolute top-16 left-3 border w-full wh-full" wire:poll.5s> --}}
<div class="relative mt-24 border">

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
        <button class="btn btn-outline btn-primary my-3" type="submit" x-on:click="scrollToBottom">
            Send
            <x-icon-send color="{{ $sendIconColor }}" />
        </button>
    </form>

    <script>
        // 2fix: auto scoll vers le bas
        document.addEventListener('livewire:load', function() {
            Livewire.on('messageAdded', function() {
                let chatContainer = document.querySelector('[x-ref="chatContainer"]');
                chatContainer.scrollTop = chatContainer.scrollHeight;
            });
        })
    </script>
</div>
