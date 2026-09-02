@extends('layouts.dashboard')

@section('page-title', 'My Jobs')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-extrabold mb-1">My jobs</h1>
            <p class="text-gray-500 text-sm">All job posts from your company</p>
        </div>
        <a href="{{ route('company.jobs.create') }}" class="text-xs font-bold px-4 py-2 rounded-lg bg-gray-900 text-white inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Post a job
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Job title</th>
                    <th class="px-5 py-3">Type</th>
                    <th class="px-5 py-3">Location</th>
                    <th class="px-5 py-3">Vacancies</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $job->job_title }}</td>
                        <td class="px-5 py-3">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</td>
                        <td class="px-5 py-3">{{ $job->location ?: '—' }}</td>
                        <td class="px-5 py-3">{{ $job->vacancies }}</td>
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
                            You haven't posted any jobs yet.
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