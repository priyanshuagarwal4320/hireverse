<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\Interview;


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

        $jobIds = $company->jobPosts()->pluck('id');

        $totalApplicants = Application::whereIn('job_post_id', $jobIds)->count();
        $shortlistedCount = Application::whereIn('job_post_id', $jobIds)->where('status', 'shortlisted')->count();

        $interviewsSetCount = Interview::whereHas('application', function ($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        })
            ->where('interview_date', '>=', now()->toDateString())
            ->count();

        $recentJobs = $company->jobPosts()->latest()->take(5)->get();

        $recentApplicants = Application::whereIn('job_post_id', $jobIds)
            ->with(['candidate.user', 'jobPost'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingInterviews = Interview::whereHas('application', function ($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        })
            ->where('interview_date', '>=', now()->toDateString())
            ->with('application.candidate.user', 'application.jobPost')
            ->orderBy('interview_date')
            ->orderBy('interview_time')
            ->take(5)
            ->get();

        return view('dashboard.company', compact(
            'company',
            'totalJobs',
            'openJobs',
            'totalApplicants',
            'shortlistedCount',
            'interviewsSetCount',
            'recentJobs',
            'recentApplicants',
            'upcomingInterviews'
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
