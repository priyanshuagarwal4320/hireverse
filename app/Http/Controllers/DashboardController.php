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
        $company = auth()->user()->company;

        $totalJobs = $company->jobPosts()->count();
        $openJobs = $company->jobPosts()->where('status', 'open')->count();

        $totalApplicants = Application::whereIn('job_post_id', $company->jobPosts()->pluck('id'))->count();

        $recentJobs = $company->jobPosts()->latest()->take(5)->get();

        return view('dashboard.company', compact(
            'company',
            'totalJobs',
            'openJobs',
            'totalApplicants',
            'recentJobs'
        ));
    }

    public function candidate()
    {
        $candidate = auth()->user()->candidate;

        $openJobs = JobPost::where('status', 'open')->with('company')->latest()->take(10)->get();

        $myApplications = $candidate
            ? $candidate->applications()->with('jobPost')->latest()->get()
            : collect();

        return view('dashboard.candidate', compact('openJobs', 'myApplications'));
    }
}
