<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectDeletedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $projectName,
        protected string $deletedBy
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Progetto cancellato',
            'body' => "Il progetto {$this->projectName} è stato cancellato da {$this->deletedBy}.",
            'status' => 'danger',
        ];
    }
}