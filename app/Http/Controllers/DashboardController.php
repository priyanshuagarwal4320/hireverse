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
        $applicationsPerMonth = Application::selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->pluck('total', 'month');

        return view('dashboard.admin', compact(
            'totalCompanies',
            'totalCandidates',
            'openJobs',
            'totalApplications',
            'recentJobs',
            'recentApplications',
            'applicationsPerMonth'
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

        $statusBreakdown = Application::whereIn('job_post_id', $jobIds)
    ->selectRaw('status, COUNT(*) as total')
    ->groupBy('status')
    ->pluck('total', 'status');

$applicationsPerJob = Application::whereIn('job_post_id', $jobIds)
    ->join('job_posts', 'applications.job_post_id', '=', 'job_posts.id')
    ->selectRaw('job_posts.job_title, COUNT(applications.id) as total')
    ->groupBy('job_posts.id', 'job_posts.job_title')
    ->orderByDesc('total')
    ->take(5)
    ->pluck('total', 'job_title');

return view('dashboard.company', compact(
    'company',
    'totalJobs',
    'openJobs',
    'totalApplicants',
    'shortlistedCount',
    'interviewsSetCount',
    'recentJobs',
    'recentApplicants',
    'upcomingInterviews',
    'statusBreakdown',
    'applicationsPerJob'
));
    }

    public function candidate(Request $request)
    {
        $candidate = auth()->user()->candidate;

        $openJobs = JobPost::where('status', 'open')
    ->when($request->search, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('job_title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    })
    ->when($request->job_type, function ($query, $type) {
        $query->where('job_type', $type);
    })
    ->when($request->min_salary, function ($query, $minSalary) {
        $query->where('salary', '>=', $minSalary);
    })
    ->when($request->max_salary, function ($query, $maxSalary) {
        $query->where('salary', '<=', $maxSalary);
    })
    ->when($request->experience, function ($query, $experience) {
        $query->where('experience', 'like', "%{$experience}%");
    })
    ->with('company')
    ->latest()
    ->take(10)
    ->get();

        $myApplications = $candidate
            ? $candidate->applications()->with('jobPost.company', 'interview')->latest()->get()
            : collect();

        $savedJobIds = $candidate
            ? $candidate->savedJobs()->pluck('job_post_id')->toArray()
            : [];

        return view('dashboard.candidate', compact('openJobs', 'myApplications', 'savedJobIds'));
    }
    public function jobDetail(JobPost $job)
    {
        abort_if($job->status !== 'open', 404);

        $candidate = auth()->user()->candidate;
        $alreadyApplied = $candidate
            ? $candidate->applications()->where('job_post_id', $job->id)->exists()
            : false;

        $job->load('company');
        $similarJobs = $job->similarJobs();

        $isSaved = $candidate
            ? $candidate->savedJobs()->where('job_post_id', $job->id)->exists()
            : false;

        return view('candidate.job-detail', compact('job', 'alreadyApplied', 'isSaved', 'similarJobs'));
    }
}
