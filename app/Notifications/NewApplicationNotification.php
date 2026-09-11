<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    public function __construct(public Application $application) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => $this->application->candidate->user->name . ' applied for ' . $this->application->jobPost->job_title,
            'url' => route('applications.show', $this->application),
        ];
    }
}