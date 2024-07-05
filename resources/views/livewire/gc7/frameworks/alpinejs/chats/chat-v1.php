<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\Message;
use Livewire\Attributes\On;
use App\Events\MessageEvent;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

new class() extends Component {
	public $message;
	public $conversation = [];

	public function mount()
	{
		Debugbar::addMessage('Récupération de la conversation');
		$messages = Message::all();
		
		foreach ($messages as $message) {
			$this->conversation[] = [
				'username' => $message->user->name,
				'message'  => $message->message,
			];
		}
	}
	
	// public function init(){
	// 	$this->dispatchBrowserEvent('content-updated');
	// }

	public function submitMessage()
	{
		Debugbar::addMessage('Envoi du dernier thread');

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
