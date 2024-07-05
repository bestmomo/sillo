<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Events\MessageEvent;
use App\Models\Message;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

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

	public function submitMessage()
	{
		Debugbar::addMessage('Envoi du dernier thread');

		// Dispatch the event
		MessageEvent::dispatch(Auth::user()->id, $this->message);

		// Reset the input field
		$this->message = '';
	}

	#[On('echo:our-channel,MessageEvent')]
	public function listenForMessage($data): void
	{
		Debugbar::addMessage('Méthode listenForMessage appelée');
		Debugbar::addMessage($data);

		$this->conversation[] = [
			'username' => $data['username'],
			'message'  => $data['message'],
		];
	}
};
