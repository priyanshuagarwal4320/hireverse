<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\JobPost;


class DashboardController extends Controller
{
    public function admin()
    {
        $totalCompanies = Company::count();
        $totalCandidates = Candidate::count();
        $openJobs = JobPost::where('status', 'open')->count();
        $totalApplications = Application::count();

        $recentJobs = JobPost::with('company')->latest()->take(5)->get();
        $recentApplications = Application::with(['candidate.user', 'jobPost'])->latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalCompanies',
            'totalCandidates',
            'openJobs',
            'totalApplications',
            'recentJobs',
            'recentApplications'
        ));
    }

    public function company()
    {
        return view('dashboard.company');
    }

    public function candidate()
    {
        return view('dashboard.candidate');
    }
}
