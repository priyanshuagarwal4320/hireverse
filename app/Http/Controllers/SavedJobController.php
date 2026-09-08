<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SavedJobController extends Controller
{
    public function index(): View
    {
        $candidate = auth()->user()->candidate;

        $savedJobs = $candidate
            ? $candidate->savedJobs()->with('jobPost.company')->latest()->paginate(10)
            : collect();

        return view('candidate.saved-jobs', compact('savedJobs'));
    }

    public function store(JobPost $job): RedirectResponse
    {
        $candidate = auth()->user()->candidate;

        $candidate->savedJobs()->firstOrCreate([
            'job_post_id' => $job->id,
        ]);

        return back()->with('status', 'Job saved to your list.');
    }

    public function destroy(JobPost $job): RedirectResponse
    {
        $candidate = auth()->user()->candidate;

        $candidate->savedJobs()->where('job_post_id', $job->id)->delete();

        return back()->with('status', 'Job removed from your saved list.');
    }
}