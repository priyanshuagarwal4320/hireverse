<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request): View
{
    $jobs = JobPost::with('company')
        ->withCount('applications')
        ->when($request->search, function ($query, $search) {
            $query->where('job_title', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return view('admin.jobs.index', compact('jobs'));
}
    public function destroy(JobPost $job): RedirectResponse
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('status', 'Job post removed successfully.');
    }
}
