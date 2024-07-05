<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Events\MessageSent;
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
		Debugbar::addMessage('Envoi dernier message');
		MessageSent::dispatch(auth()->user()->name, $this->message);
		$this->reset('message');
	}

	#[On('echo:messages,MessageSent')]
	public function onMessageSent($event)
	{
		Debugbar::addMessage('Réception dernier message');
		// dd($event);
		$this->messages[] = [
			'name'    => $event['name'],
			'message' => $event['text'],
		];
	}
};
