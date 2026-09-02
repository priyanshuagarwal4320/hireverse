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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: job listings --}}
        <div class="lg:col-span-2 space-y-3">
            @forelse($openJobs as $job)
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-sm mb-1">{{ $job->job_title }}</h4>
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
                    <form method="POST" action="{{ route('applications.store', $job) }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold px-4 py-2 rounded-lg bg-gray-900 text-white">
                            Apply now
                        </button>
                    </form>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                    No open jobs right now. Check back soon.
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
                    <div class="flex items-center justify-between px-3 py-3 border-b border-gray-100 last:border-0">
                        <span class="text-sm">{{ $app->jobPost->job_title }}</span>
                        <span
                            class="text-xs font-bold px-3 py-1 rounded-full
                            @if ($app->status === 'pending') bg-amber-50 text-amber-700
                            @elseif($app->status === 'shortlisted') bg-violet-50 text-violet-700
                            @elseif($app->status === 'selected') bg-green-50 text-green-700
                            @else bg-red-50 text-red-700 @endif">
                            {{ ucfirst($app->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm py-6">You haven't applied to any jobs yet.</p>
                @endforelse
            </div>
        </div>

    </div>

@endsection
