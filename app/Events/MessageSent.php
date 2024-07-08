<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

namespace App\Events;

use Illuminate\Broadcasting\{InteractsWithSockets, PrivateChannel};
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast, ShouldQueue
{
	use Dispatchable;
	use InteractsWithSockets;
	use SerializesModels;

	/**
	 * Create a new event instance.
	 */
	public function __construct(
		public string $name,
		public string $text
	) {
		// $newMessage          = new Message();
		// $newMessage->user_id = 1;
		// $newMessage->message = $text;
		// $newMessage->save();

		// $this->message  = $message;
		// $this->username = User::find($user_id)->name;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel;
	 */
	public function broadcastOn(): PrivateChannel
	{
		return new PrivateChannel('messages');
	}
}
