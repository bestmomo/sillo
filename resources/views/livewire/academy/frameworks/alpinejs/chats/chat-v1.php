<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use App\Events\AcademyChatV1MessageEvent;
use App\Models\AcademyChatV1Message;
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
		$messages = AcademyChatV1Message::all();

		foreach ($messages as $message) {
			$this->conversation[] = [
				'username' => $message->user->name,
				'message'  => $message->message,
			];
		}
	}

	public function submitMessage()
	{
		Debugbar::addMessage('Envoi du dernier thread: ' . $this->message);

		// Dispatch the event
		AcademyChatV1MessageEvent::dispatch(Auth::user()->id, $this->message);

		// Reset the input field
		$this->message = '';
	}

	#[On('echo:chat-v1-channel,AcademyChatV1MessageEvent')]
	public function listenForMessage($data): void
	{
		Debugbar::addMessage('Méthode listenForMessage chat V1 appelée');
		Debugbar::addMessage($data);

		$this->conversation[] = [
			'username' => $data['username'],
			'message'  => $data['message'],
		];
	}
};
