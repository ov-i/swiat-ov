<?php

namespace App\Notifications\Tickets;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyOperatorAboutTicket extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Ticket $ticket,
    ) {
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
        return $this->buildMessage();
    }

    public function buildMessage(): MailMessage
    {
        /** @var User $user */
        $user = $this->ticket->user()->first();
        // TODO: Localize message content
        return (new MailMessage())
            ->subject("New ticket from user [{$user->email}}]")
            ->line("Hi, you've been assigned to a ")
            ->line('If you\'re the one who changed it, take some rest');
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
