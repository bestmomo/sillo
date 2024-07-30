<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Notifications;

use App\models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAnswerCreated extends Notification
{
	use Queueable;

	public Comment $comment;

	/**
	 * Create a new notification instance.
	 */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via(object $notifiable): array
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage())
			->subject(__('An answer has been created on your comment'))
			->line(__('An answer has been created on your comment') . ' "' . $this->comment->post->title . '" ' . __('by') . ' ' . $this->comment->user->name . '.')
			->line('"' . $this->comment->body . '"')
			->action(__('Show this comment'), route('posts.show', $this->comment->post->slug));
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(object $notifiable): array
	{
		return [
		];
	}
}
