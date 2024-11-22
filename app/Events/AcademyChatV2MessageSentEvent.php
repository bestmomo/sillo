<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Events;

use Illuminate\Broadcasting\{InteractsWithSockets, PrivateChannel};
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcademyChatV2MessageSentEvent implements ShouldBroadcast, ShouldQueue {
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
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel;
	 */
	public function broadcastOn(): PrivateChannel {
		return new PrivateChannel('chat-v2-private-channel');
	}
}
