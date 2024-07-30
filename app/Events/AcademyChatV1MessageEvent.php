<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Events;

use App\Models\{AcademyChatV1Message, User};
use Illuminate\Broadcasting\{Channel, InteractsWithSockets};
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcademyChatV1MessageEvent implements ShouldBroadcastNow
{
	use Dispatchable;
	use InteractsWithSockets;
	use SerializesModels;

	// To start Broadcasting:
	// php .\artisan reverb:start

	public $username;
	public $message;

	/**
	 * Create a new event instance.
	 */
	public function __construct($user_id, $message)
	{
		$newMessage          = new AcademyChatV1Message();
		$newMessage->user_id = $user_id;
		$newMessage->message = $message;
		$newMessage->save();

		$this->message  = $message;
		$this->username = User::find($user_id)->name;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('chat-v1-channel'),
		];
	}
}
