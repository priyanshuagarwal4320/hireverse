@extends('layouts.dashboard')

@section('page-title', $job->job_title)

@section('content')

    <a href="{{ route('candidate.dashboard') }}" class="text-xs font-semibold text-gray-500">&larr; Back to jobs</a>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 mt-4 max-w-3xl">
        <div class="flex items-center gap-4 mb-6">
            @if ($job->company->logo)
                <img src="{{ asset('storage/' . $job->company->logo) }}" class="w-14 h-14 rounded-xl object-cover">
            @else
                <div
                    class="w-14 h-14 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-xl">
                    {{ strtoupper(substr($job->company->company_name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h1 class="text-xl font-extrabold">{{ $job->job_title }}</h1>
                <p class="text-sm text-gray-500">{{ $job->company->company_name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 pb-6 border-b border-gray-100">
            <div>
                <p class="text-xs text-gray-400 font-semibold">Location</p>
                <p class="text-sm font-bold">{{ $job->location ?: 'Remote' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">Type</p>
                <p class="text-sm font-bold">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">Experience</p>
                <p class="text-sm font-bold">{{ $job->experience ?: 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">Salary</p>
                <p class="text-sm font-bold">{{ $job->salary ? '₹' . number_format($job->salary) : 'Not disclosed' }}</p>
            </div>
        </div>

        <h3 class="text-sm font-bold mb-2">Job description</h3>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line mb-6">{{ $job->job_description }}</p>

        @if ($job->company->about)
            <h3 class="text-sm font-bold mb-2">About {{ $job->company->company_name }}</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $job->company->about }}</p>
        @endif

        <div class="flex items-center gap-3">
            @if ($alreadyApplied)
                <span class="inline-block text-sm font-bold px-6 py-3 rounded-lg bg-green-50 text-green-700">
                    <i class="fas fa-check-circle mr-1"></i> Already applied
                </span>
            @else
                <form method="POST" action="{{ route('applications.store', $job) }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-white px-6 py-3 rounded-lg"
                        style="background:#171a2e;">
                        Apply now
                    </button>
                </form>
            @endif

            @if ($isSaved)
                <form method="POST" action="{{ route('jobs.unsave', $job) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-sm font-bold px-6 py-3 rounded-lg border border-violet-200 text-violet-700 bg-violet-50">
                        <i class="fas fa-bookmark mr-1"></i> Saved
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('jobs.save', $job) }}">
                    @csrf
                    <button type="submit"
                        class="text-sm font-bold px-6 py-3 rounded-lg border border-gray-200 text-gray-600">
                        <i class="far fa-bookmark mr-1"></i> Save job
                    </button>
                </form>
            @endif
        </div>
    </div>
    @if ($similarJobs->count() > 0)
        <div class="mt-6 max-w-3xl">
            <h3 class="text-sm font-bold mb-3">Similar jobs</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ($similarJobs as $similarJob)
                    <a href="{{ route('candidate.job.detail', $similarJob) }}"
                        class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:border-violet-400 block">
                        <p class="font-bold text-sm mb-1">{{ $similarJob->job_title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $similarJob->company->company_name }}
                            @if ($similarJob->location)
                                &middot; {{ $similarJob->location }}
                            @endif
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

@endsection
