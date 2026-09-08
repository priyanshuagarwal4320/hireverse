@extends('layouts.dashboard')

@section('page-title', 'Saved Jobs')

@section('content')

    @if (session('status'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <h1 class="text-xl font-extrabold mb-1">Saved jobs</h1>
    <p class="text-gray-500 text-sm mb-6">Jobs you've bookmarked to apply later</p>

    <div class="space-y-3">
        @forelse ($savedJobs as $saved)
            @php $job = $saved->jobPost; @endphp
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <a href="{{ route('candidate.job.detail', $job) }}"
                        class="font-bold text-sm mb-1 hover:text-violet-600 block">
                        {{ $job->job_title }}
                    </a>
                    <p class="text-xs text-gray-500">
                        {{ $job->company->company_name }}
                        @if ($job->location)
                            &middot; {{ $job->location }}
                        @endif
                        &middot; {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}
                        @if ($job->status !== 'open')
                            &middot; <span class="text-red-500 font-semibold">Closed</span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('candidate.job.detail', $job) }}"
                        class="text-xs font-semibold text-gray-500 px-3 py-2">
                        View details
                    </a>
                    <form method="POST" action="{{ route('jobs.unsave', $job) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Remove from saved" class="text-sm text-violet-600 px-3 py-2">
                            <i class="fas fa-bookmark"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                You haven't saved any jobs yet.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $savedJobs->links() }}
    </div>

@endsection