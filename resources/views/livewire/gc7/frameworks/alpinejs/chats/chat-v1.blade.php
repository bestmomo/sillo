<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Events\MessageEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public $message;
    public $conversation = [];

    public function mount()
    {
        $messages = Message::all();
        foreach ($messages as $message) {
            $this->conversation[] = [
                'username' => $message->user->name,
                'message' => $message->message,
            ];
        }
    }

    public function submitMessage()
    {
        // dump($this->message);

        // Dispatch the event
        // $this->emit('newMessage', $this->message);
        MessageEvent::dispatch(Auth::user()->id, $this->message);

        // Reset the input field
        $this->message = '';
        // $this->conversation[] = $this->message;
    }

    #[On('echo:our-channel,MessageEvent')]
    public function listenForMessage($data): void
    {
        $this->conversation[] = [
            'username' => $data['username'],
            'message' => $data['message'],
        ];
    }
};
?>

<div>

    <div class="flex gap-4 items-center justify-around w-[150px]">
        <h1>V1</h1>
        <p><a class='link m-0 p-0 b-6' href="https://www.youtube.com/watch?v=huLSxcxFRl4&list=PLr0BjDocnuI1JdTA9aIj5LIM6wcYpvnbq&index=9" target='_blank'
                title='Vidéo source'>(Source - 31')</a>
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
