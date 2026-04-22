<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $projectName
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Nuovo progetto creato',
            'body' => "Il progetto {$this->projectName} è stato creato correttamente.",
            'status' => 'success',
        ];
    }
}