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

    {{-- <form class="mt-2" wire:submit.prevent="submitMessage" x-data x-init="$nextTick(() => $refs.messageInput.focus())">
        <x-input wire:model="message" x-ref="messageInput" />
        <button class="btn btn-outline btn-primary my-3" type="submit">
            Send
            <x-icon-send color="{{ $sendIconColor }}" />
        </button>
    </form> --}}

    <form class="mt-2" wire:submit.prevent="submitMessage">
        <x-input wire:model="message" input="v1" />
        <button class="btn btn-outline btn-primary my-3" type="submit">
            Send
            <x-icon-send color="{{ $sendIconColor }}" />
        </button>
    </form>

    @section('scripts')
        <script>
            function focusInput() {
                setTimeout(function() {
                    const input = document.querySelector('input[input="v1"]');
                    if (input) {
                        console.log('Trouvé elt input v1')
                        input.focus();
                    }

                    // Focus initial
                    document.addEventListener('DOMContentLoaded', focusInput);

                    // Focus lors du focus de la fenêtre
                    window.addEventListener('focus', focusInput);

                    // Focus lors des mises à jour Livewire
                    // window.addEventListener('content-updated', focusInput);

                }, 700);
            }
        </script>
    @endsection
</div>
