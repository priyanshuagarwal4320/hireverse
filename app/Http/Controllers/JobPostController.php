<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobPostController extends Controller
{

    public function index(): View
{
    $company = auth()->user()->company;

    $jobs = $company->jobPosts()->latest()->paginate(10);
    $openCount = $company->jobPosts()->where('status', 'open')->count();
    $closedCount = $company->jobPosts()->where('status', 'closed')->count();

    return view('company.jobs.index', compact('jobs', 'openCount', 'closedCount'));
}

    public function create(): View
    {
        return view('company.jobs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'job_description' => ['required', 'string', 'max:5000'],
            'job_type' => ['required', 'in:full_time,part_time,contract,internship'],
            'experience' => ['nullable', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'vacancies' => ['required', 'integer', 'min:1'],
            'last_date' => ['nullable', 'date', 'after:today'],
        ]);

        $company->jobPosts()->create($validated);

        return redirect()->route('company.jobs.index')->with('status', 'Job posted successfully.');
    }
}
