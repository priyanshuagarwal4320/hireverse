<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
{
    $candidate = auth()->user()->candidate;

    $applications = $candidate
        ? $candidate->applications()->with('jobPost.company')->latest()->paginate(10)
        : collect();

    return view('candidate.applications', compact('applications'));
}
    public function store(JobPost $job): RedirectResponse
    {
        $candidate = auth()->user()->candidate;

        $alreadyApplied = $candidate->applications()->where('job_post_id', $job->id)->exists();

        if ($alreadyApplied) {
            return redirect()->route('candidate.dashboard')->with('status', 'You have already applied to this job.');
        }

        $candidate->applications()->create([
            'job_post_id' => $job->id,
            'applied_date' => now(),
        ]);

        return redirect()->route('candidate.dashboard')->with('status', 'Application submitted successfully!');
    }
    public function updateStatus(Request $request, Application $application): RedirectResponse
    {
        $companyId = $application->jobPost->company_id;

        abort_if($companyId !== auth()->user()->company->id, 403);

        $request->validate([
            'status' => ['required', 'in:pending,shortlisted,rejected,selected'],
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('status', 'Application status updated.');
    }
}
