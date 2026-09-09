<?php

namespace App\Console\Commands;

use App\Models\JobPost;
use Illuminate\Console\Command;

class CloseExpiredJobs extends Command
{
    protected $signature = 'jobs:close-expired';

    protected $description = 'Automatically close job posts whose application deadline has passed';

    public function handle(): void
    {
        $count = JobPost::where('status', 'open')
            ->whereNotNull('last_date')
            ->where('last_date', '<', now()->toDateString())
            ->update(['status' => 'closed']);

        $this->info("Closed {$count} expired job post(s).");
    }
}