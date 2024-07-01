<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Events\MessageEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class() extends Component {
	public $message;
	public $conversation = [];

	public function mount()
	{
		$messages = Message::all();
		foreach ($messages as $message) {
			$this->conversation[] = [
				'username' => $message->user->name,
				'message'  => $message->message,
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
			'message'  => $data['message'],
		];
	}
};
