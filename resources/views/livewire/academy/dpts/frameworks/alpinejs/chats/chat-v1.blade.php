<?php
include_once 'chat-v1.php';
?>

<div class="relative mt-24" 
     x-data="{ 
         scrollToBottom() {
             this.$nextTick(() => {
                 this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
             });
         }
     }"
     x-init="
         Livewire.on('messageAdded', () => scrollToBottom());
         $watch('$wire.conversation', () => scrollToBottom());
     "
>
    <ul x-ref="chatContainer" style="max-height: 400px; overflow-y: auto;">
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
