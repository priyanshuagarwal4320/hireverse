@extends('layouts.dashboard')

@section('page-title', 'Jobs')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Jobs</h1>
    <p class="text-gray-500 text-sm mb-6">All job posts across every company</p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Job title</th>
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Location</th>
                    <th class="px-5 py-3">Applications</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $job->job_title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $job->company->company_name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $job->location ?: '—' }}</td>
                        <td class="px-5 py-3">{{ $job->applications_count }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full
                                {{ $job->status === 'open' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            No jobs posted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $jobs->links() }}
    </div>

@endsection