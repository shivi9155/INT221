<?php

namespace App\Notifications;

use App\Models\Grievance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GrievanceActivityNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Grievance $grievance,
        private readonly string $title,
        private readonly string $message,
    ) {
    }

    public function via(object $notifiable): array
    {
        $channels = [];

        if ($notifiable->wants_in_app_notifications ?? true) {
            $channels[] = 'database';
        }

        if ($notifiable->wants_email_notifications ?? true) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($this->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->message)
            ->line('Ticket ID: '.$this->grievance->ticket_id)
            ->action('View grievance', route('grievances.show', $this->grievance))
            ->line('ResolveX will keep the ticket timeline updated as the case moves forward.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'ticket_id' => $this->grievance->ticket_id,
            'grievance_id' => $this->grievance->id,
            'status' => $this->grievance->status,
        ];
    }
}
