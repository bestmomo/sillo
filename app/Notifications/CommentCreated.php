<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\models\Comment;

class CommentCreated extends Notification
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
        return (new MailMessage)
                    ->subject(__('A comment has been created on your post'))
                    ->line(__('A comment has been created on your post') . ' "' . $this->comment->post->title . '" ' . __('by') . ' ' . $this->comment->user->name . '.')
                    ->line('"' . $this->comment->body . '"')
                    ->lineIf(!$this->comment->user->valid, __('This comment is awaiting moderation.'))
                    ->action(__('Manage this comment'), route('comments.index'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
