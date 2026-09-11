<?php

namespace App\Notifications;

use App\Models\Interview;
use Illuminate\Notifications\Notification;

class InterviewScheduled extends Notification
{
    public function __construct(public Interview $interview) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Interview scheduled for ' . $this->interview->application->jobPost->job_title . ' on ' . $this->interview->interview_date->format('d M Y'),
            'url' => route('candidate.interviews'),
        ];
    }
}