<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Interview;

class InterviewController extends Controller
{
    public function create(Application $application): View
    {
        $companyId = $application->jobPost->company_id;

        abort_if($companyId !== auth()->user()->company->id, 403);

        return view('company.interviews.create', compact('application'));
    }

    public function store(Request $request, Application $application): RedirectResponse
    {
        $companyId = $application->jobPost->company_id;

        abort_if($companyId !== auth()->user()->company->id, 403);

        $validated = $request->validate([
            'interview_date' => ['required', 'date', 'after_or_equal:today'],
            'interview_time' => ['required'],
            'mode' => ['required', 'in:online,offline'],
            'meeting_link' => ['nullable', 'string', 'max:255'],
        ]);

        $application->interview()->create($validated);

        return redirect()->route('company.jobs.applicants', $application->job_post_id)
            ->with('status', 'Interview scheduled successfully.');
    }

    public function index(): View
    {
        $candidate = auth()->user()->candidate;

        $interviews = $candidate
            ? Interview::whereHas('application', function ($query) use ($candidate) {
                $query->where('candidate_id', $candidate->id);
            })->with('application.jobPost.company')->latest()->get()
            : collect();

        return view('candidate.interviews', compact('interviews'));
    }

    public function companyIndex(): View
    {
        $company = auth()->user()->company;

        $jobIds = $company->jobPosts()->pluck('id');

        $interviews = Interview::whereHas('application', function ($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        })
            ->with('application.candidate.user', 'application.jobPost')
            ->orderBy('interview_date')
            ->paginate(15);

        return view('company.interviews.index', compact('interviews'));
    }
}
