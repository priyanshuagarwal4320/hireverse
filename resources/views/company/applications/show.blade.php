@extends('layouts.dashboard')

@section('page-title', 'Applicant Details')

@section('content')

    <div class="mb-6">
        <a href="{{ route('company.jobs.applicants', $application->job_post_id) }}"
            class="text-xs font-semibold text-gray-500">&larr; Back to Applicants</a>
        <h1 class="text-xl font-extrabold mt-2 mb-1">{{ $application->candidate->user->name }}</h1>
        <p class="text-gray-500 text-sm">Applied for {{ $application->jobPost->job_title }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: profile details --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-bold">Contact information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">Email</p>
                        <p class="font-semibold">{{ $application->candidate->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">Mobile</p>
                        <p class="font-semibold">{{ $application->candidate->mobile ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">City</p>
                        <p class="font-semibold">{{ $application->candidate->city ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">Gender</p>
                        <p class="font-semibold">
                            {{ $application->candidate->gender ? ucfirst($application->candidate->gender) : 'Not provided' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-bold">Professional details</h3>
                </div>
                <div class="p-6 space-y-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">Qualification</p>
                        <p class="font-semibold">{{ $application->candidate->qualification ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">Experience</p>
                        <p class="font-semibold">{{ $application->candidate->experience ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold mb-1">Skills</p>
                        <p class="font-semibold">{{ $application->candidate->skills ?: 'Not provided' }}</p>
                    </div>
                    @if ($application->candidate->resume)
                        <div>
                            <p class="text-xs text-gray-400 font-semibold mb-1">Resume</p>
                            <a href="{{ route('candidate.resume.download', $application->candidate) }}"
                                class="inline-flex items-center gap-1 text-sm font-bold text-violet-600">
                                <i class="fas fa-file-pdf"></i> Download resume
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Right: status + actions --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Photo</p>
                    </div>
                    <div class="p-5 flex justify-center">
                        @if ($application->candidate->profile_photo)
                            <img src="{{ asset('storage/' . $application->candidate->profile_photo) }}"
                                class="w-24 h-24 rounded-2xl object-cover">
                        @else
                            <div
                                class="w-24 h-24 rounded-2xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-2xl">
                                {{ strtoupper(substr($application->candidate->user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Application status</p>
                    </div>
                    <div class="p-5">
                        <span
                            class="text-xs font-bold px-3 py-1 rounded-full
                            @if ($application->status === 'pending') bg-amber-50 text-amber-700
                            @elseif($application->status === 'shortlisted') bg-violet-50 text-violet-700
                            @elseif($application->status === 'selected') bg-green-50 text-green-700
                            @else bg-red-50 text-red-700 @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-3">Applied {{ $application->applied_date->format('d M Y') }}</p>

                        @if ($application->interview)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase mb-2">Interview</p>
                                <p class="text-xs">{{ $application->interview->interview_date->format('d M Y') }} at
                                    {{ \Carbon\Carbon::parse($application->interview->interview_time)->format('h:i A') }}
                                </p>
                                @if ($application->interview->result)
                                    <p
                                        class="text-xs font-bold mt-1 {{ $application->interview->result->status === 'pass' ? 'text-green-600' : 'text-red-600' }}">
                                        Result: {{ ucfirst($application->interview->result->status) }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
