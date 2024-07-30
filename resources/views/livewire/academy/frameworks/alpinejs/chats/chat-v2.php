<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

use App\Events\AcademyChatV2MessageSentEvent;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class() extends Component {
	/**
	 * @var string[]
	 */
	public array $messages = [];

	public string $message = '';

	public function addMessage()
	{
		Debugbar::addMessage('Envoi du dernier message: ' . $this->message);
		AcademyChatV2MessageSentEvent::dispatch(auth()->user()->name, $this->message);
		$this->reset('message');
	}

	#[On('echo-private:chat-v2-private-channel,AcademyChatV2MessageSentEvent')]
	public function onMessageSent($event)
	{
		Debugbar::addMessage('Réception dernier message privé chat V2 → ' . $event['name'] . ': ' . $event['text']);
		// dd($event);
		$this->messages[] = [
			'name'    => $event['name'],
			'message' => $event['text'],
		];
	}
};
