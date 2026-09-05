<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobController extends Controller
{
    public function index(): View
    {
        $jobs = JobPost::with('company')->withCount('applications')->latest()->paginate(15);

        return view('admin.jobs.index', compact('jobs'));
    }
    public function destroy(JobPost $job): RedirectResponse
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('status', 'Job post removed successfully.');
    }
}
