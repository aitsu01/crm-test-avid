<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectsBulkDeletedNotification extends Notification
{
    use Queueable;

    /**
     * @param array<int, string> $projectNames
     */
    public function __construct(
        protected array $projectNames,
        protected string $deletedBy
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $names = implode(', ', $this->projectNames);

        return [
            'title' => 'Progetti cancellati',
            'body' => "I progetti {$names} sono stati cancellati da {$this->deletedBy}.",
            'status' => 'danger',
        ];
    }
}