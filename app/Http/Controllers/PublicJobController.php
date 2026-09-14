<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicJobController extends Controller
{
    public function index(Request $request): View
    {
        $jobs = JobPost::where('status', 'open')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('job_title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when($request->job_type, function ($query, $type) {
                $query->where('job_type', $type);
            })
            ->with('company')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('public.jobs', compact('jobs'));
    }

    public function show(JobPost $job): View
    {
        abort_if($job->status !== 'open', 404);
        $job->incrementViews();
        $similarJobs = $job->similarJobs();
        return view('public.job-detail', compact('job', 'similarJobs'   ));
    }
}
