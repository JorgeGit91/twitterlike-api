<?php

namespace Modules\Comment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Notifications\CommentCreated as Mailable;

class CommentCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private Comment $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        //
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Someone commented on your post!!!')
            ->line('User:   ' . $this->comment->user->email)
            ->action('Notification Action', 'https://laravel.com')
            ->line('Commented:')
            ->line($this->comment->text)
            ->line('On your post:')
            ->line($this->comment->post->text);
    }
   
    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
