@extends('layouts.dashboard')

@section('page-title', 'Browse Jobs')

@section('content')

    @if (session('status'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif
    <h1 class="text-xl font-extrabold mb-1">Browse jobs</h1>
    <p class="text-gray-500 text-sm mb-6">Matched to your profile and skills</p>

    <form method="GET" action="{{ route('candidate.dashboard') }}"
        class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-6 flex flex-col gap-3">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by job title or location..."
                    class="block w-full pl-9 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            </div>
            <select name="job_type"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <option value="">All types</option>
                <option value="full_time" {{ request('job_type') === 'full_time' ? 'selected' : '' }}>Full time</option>
                <option value="part_time" {{ request('job_type') === 'part_time' ? 'selected' : '' }}>Part time</option>
                <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                <option value="internship" {{ request('job_type') === 'internship' ? 'selected' : '' }}>Internship</option>
            </select>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select name="experience"
                class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <option value="">All experience levels</option>
                <option value="Fresher" {{ request('experience') === 'Fresher' ? 'selected' : '' }}>Fresher</option>
                <option value="0-1" {{ request('experience') === '0-1' ? 'selected' : '' }}>0-1 Years</option>
                <option value="1-3" {{ request('experience') === '1-3' ? 'selected' : '' }}>1-3 Years</option>
                <option value="3-5" {{ request('experience') === '3-5' ? 'selected' : '' }}>3-5 Years</option>
                <option value="5" {{ request('experience') === '5' ? 'selected' : '' }}>5+ Years</option>
            </select>
            <input type="number" name="min_salary" value="{{ request('min_salary') }}" placeholder="Min salary"
                class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            <input type="number" name="max_salary" value="{{ request('max_salary') }}" placeholder="Max salary"
                class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            <button type="submit" class="text-xs font-bold px-5 py-2 rounded-lg text-white whitespace-nowrap"
                style="background:#171a2e;">
                Search
            </button>
            @if (request('search') || request('job_type') || request('experience') || request('min_salary') || request('max_salary'))
                <a href="{{ route('candidate.dashboard') }}"
                    class="text-xs font-semibold text-gray-400 self-center whitespace-nowrap">Clear</a>
            @endif
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: job listings --}}
        <div class="lg:col-span-2 space-y-3">
            @forelse($openJobs as $job)
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
                            @if ($job->salary)
                                &middot; &#8377;{{ number_format($job->salary) }}
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if (in_array($job->id, $savedJobIds))
                            <form method="POST" action="{{ route('jobs.unsave', $job) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Remove from saved" class="text-sm text-violet-600 px-3 py-2">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('jobs.save', $job) }}">
                                @csrf
                                <button type="submit" title="Save job"
                                    class="text-sm text-gray-400 hover:text-violet-600 px-3 py-2">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('candidate.job.detail', $job) }}"
                            class="text-xs font-semibold text-gray-500 px-3 py-2">
                            View details
                        </a>
                        <form method="POST" action="{{ route('applications.store', $job) }}">
                            @csrf
                            <button type="submit" class="text-xs font-bold px-4 py-2 rounded-lg bg-gray-900 text-white">
                                Apply now
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                    No jobs found matching your search.
                </div>
            @endforelse
        </div>

        {{-- Right: my applications --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden h-fit">
            <div class="px-5 py-4 border-b border-gray-200">
                <h3 class="text-sm font-bold">My applications</h3>
            </div>
                        <div class="p-2">
                @forelse($myApplications as $app)
                    <div class="px-3 py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ $app->jobPost->job_title }} <span
                                    class="text-gray-400">({{ $app->jobPost->company->company_name }})</span></span>
                            <span class="text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap ml-2
                                @if ($app->status === 'pending') bg-amber-50 text-amber-700
                                @elseif($app->status === 'shortlisted') bg-violet-50 text-violet-700
                                @elseif($app->status === 'selected') bg-green-50 text-green-700
                                @elseif($app->status === 'withdrawn') bg-gray-100 text-gray-500
                                @else bg-red-50 text-red-700 @endif">
                                {{ ucfirst($app->status) }}
                            </span>
                        </div>
                        @if ($app->status !== 'withdrawn')
                            <p class="text-xs text-gray-400 mt-1">{{ $app->currentStage() }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm py-6">You haven't applied to any jobs yet.</p>
                @endforelse
            </div>
        </div>

    </div>

@endsection
