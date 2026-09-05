@extends('layouts.dashboard')

@section('page-title', 'Admin Dashboard')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Platform overview</h1>
    <p class="text-gray-500 text-sm mb-6">Everything happening across HireVerse right now</p>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                <i class="fas fa-building text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $totalCompanies }}</p>
            <p class="text-sm text-gray-500 font-semibold">Companies</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mb-3">
                <i class="fas fa-users text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $totalCandidates }}</p>
            <p class="text-sm text-gray-500 font-semibold">Candidates</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <i class="fas fa-briefcase text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $openJobs }}</p>
            <p class="text-sm text-gray-500 font-semibold">Open jobs</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-3">
                <i class="fas fa-file-lines text-sm"></i>
            </div>
            <p class="text-2xl font-extrabold">{{ $totalApplications }}</p>
            <p class="text-sm text-gray-500 font-semibold">Applications</p>
        </div>
    </div>


    {{-- Recent jobs --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-bold">Recent jobs</h3>
            <a href="{{ route('admin.jobs.index') }}" class="text-xs font-bold text-violet-600">View all</a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Job title</th>
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Location</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentJobs as $job)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3">{{ $job->job_title }}</td>
                        <td class="px-5 py-3">{{ $job->company->company_name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $job->location ?: '—' }}</td>
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
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">No job posts yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent applications --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-bold">Recent applications</h3>
            <a href="{{ route('admin.applications.index') }}" class="text-xs font-bold text-violet-600">View all</a>
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
                @forelse($recentApplications as $app)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3">{{ $app->candidate->user->name }}</td>
                        <td class="px-5 py-3">{{ $app->jobPost->job_title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $app->applied_date->format('d M Y') }}</td>
                        <td class="px-5 py-3">
                            <span
                                class="text-xs font-bold px-3 py-1 rounded-full
                            @if ($app->status === 'pending') bg-amber-50 text-amber-700
                            @elseif($app->status === 'shortlisted') bg-violet-50 text-violet-700
                            @elseif($app->status === 'selected') bg-green-50 text-green-700
                            @else bg-red-50 text-red-700 @endif">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">No applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
