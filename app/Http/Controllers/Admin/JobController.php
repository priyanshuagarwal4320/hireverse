<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        $jobs = JobPost::with('company')->withCount('applications')->latest()->paginate(15);

        return view('admin.jobs.index', compact('jobs'));
    }
}