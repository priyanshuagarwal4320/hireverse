<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResultController extends Controller
{
    public function create(Interview $interview): View
    {
        $companyId = $interview->application->jobPost->company_id;

        abort_if($companyId !== auth()->user()->company->id, 403);

        return view('company.results.create', compact('interview'));
    }

    public function store(Request $request, Interview $interview): RedirectResponse
    {
        $companyId = $interview->application->jobPost->company_id;

        abort_if($companyId !== auth()->user()->company->id, 403);

        $validated = $request->validate([
            'score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:pass,fail'],
        ]);

        $interview->result()->create($validated);

        return redirect()->route('company.jobs.applicants', $interview->application->job_post_id)
            ->with('status', 'Result recorded successfully.');
    }

    public function index(): View
    {
        $candidate = auth()->user()->candidate;

        $results = $candidate
            ? Result::whereHas('interview.application', function ($query) use ($candidate) {
                $query->where('candidate_id', $candidate->id);
            })->with('interview.application.jobPost.company')->latest()->get()
            : collect();

        return view('candidate.results', compact('results'));
    }
}