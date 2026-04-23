<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $projectName,
        protected string $updatedBy
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Progetto modificato',
            'body' => "Il progetto {$this->projectName} è stato modificato da {$this->updatedBy}.",
            'status' => 'warning',
        ];
    }
}