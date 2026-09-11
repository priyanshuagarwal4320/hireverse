<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    public function __construct(public Application $application) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Your application for ' . $this->application->jobPost->job_title . ' is now ' . ucfirst($this->application->status),
            'url' => route('candidate.applications'),
        ];
    }
}