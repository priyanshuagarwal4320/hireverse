@extends('layouts.dashboard')

@section('page-title', 'Company Dashboard')

@section('content')

    <div class="flex items-center justify-between mb-1">
        <h1 class="text-xl font-extrabold">{{ $company->company_name }}</h1>
        <a href="{{ route('company.jobs.create') }}"
            class="text-xs font-bold px-4 py-2 rounded-lg bg-gray-900 text-white inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Post a job
        </a>
    </div>
    <p class="text-gray-500 text-sm mb-6">Manage your job postings and applicants</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                <i class="fas fa-briefcase text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $openJobs }}</p>
            <p class="text-sm text-gray-500 font-semibold">Open jobs</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mb-3">
                <i class="fas fa-users text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $totalApplicants }}</p>
            <p class="text-sm text-gray-500 font-semibold">Total applicants</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-3">
                <i class="fas fa-star text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $shortlistedCount }}</p>
            <p class="text-sm text-gray-500 font-semibold">Shortlisted</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <i class="fas fa-calendar-check text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $interviewsSetCount }}</p>
            <p class="text-sm text-gray-500 font-semibold">Interviews set</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-bold">My job posts</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Job title</th>
                    <th class="px-5 py-3">Type</th>
                    <th class="px-5 py-3">Vacancies</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentJobs as $job)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3">{{ $job->job_title }}</td>
                        <td class="px-5 py-3">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</td>
                        <td class="px-5 py-3">{{ $job->vacancies }}</td>
                        <td class="px-5 py-3">
                            <span
                                class="text-xs font-bold px-3 py-1 rounded-full
                                {{ $job->status === 'open' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">
                            You haven't posted any jobs yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mt-6">
        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-bold">Recent applicants</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Candidate</th>
                    <th class="px-5 py-3">Job</th>
                    <th class="px-5 py-3">Applied</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentApplicants as $application)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $application->candidate->user->name }}</td>
                        <td class="px-5 py-3">{{ $application->jobPost->job_title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $application->applied_date->format('d M Y') }}</td>
                        <td class="px-5 py-3">
                            <span
                                class="text-xs font-bold px-3 py-1 rounded-full
                            @if ($application->status === 'pending') bg-amber-50 text-amber-700
                            @elseif($application->status === 'shortlisted') bg-violet-50 text-violet-700
                            @elseif($application->status === 'selected') bg-green-50 text-green-700
                            @else bg-red-50 text-red-700 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">No applicants yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mt-6">
        <div class="px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-bold">Upcoming interviews</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Candidate</th>
                    <th class="px-5 py-3">Job</th>
                    <th class="px-5 py-3">Date</th>
                    <th class="px-5 py-3">Time</th>
                    <th class="px-5 py-3">Mode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingInterviews as $interview)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $interview->application->candidate->user->name }}</td>
                        <td class="px-5 py-3">{{ $interview->application->jobPost->job_title }}</td>
                        <td class="px-5 py-3">{{ $interview->interview_date->format('d M Y') }}</td>
                        <td class="px-5 py-3">{{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</td>
                        <td class="px-5 py-3">
                            <span
                                class="text-xs font-bold px-3 py-1 rounded-full {{ $interview->mode === 'online' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ ucfirst($interview->mode) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">No upcoming interviews.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
