@extends('layouts.dashboard')

@section('page-title', 'Schedule Interview')

@section('content')

    <div class="mb-6">
        <a href="{{ route('company.jobs.applicants', $application->job_post_id) }}"
            class="text-xs font-semibold text-gray-500">&larr; Back to Applicants</a>
        <h1 class="text-xl font-extrabold mt-2 mb-1">Schedule interview</h1>
        <p class="text-gray-500 text-sm">
            For <strong>{{ $application->candidate->user->name }}</strong> — {{ $application->jobPost->job_title }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('interviews.store', $application) }}" class="space-y-6"
                x-data="{ mode: '{{ old('mode', 'online') }}' }">
                @csrf

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Interview details</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input-label for="interview_date" :value="__('Date')" />
                                <x-text-input id="interview_date" name="interview_date" type="date"
                                    class="block mt-1 w-full" :value="old('interview_date')" required />
                                <x-input-error :messages="$errors->get('interview_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="interview_time" :value="__('Time')" />
                                <x-text-input id="interview_time" name="interview_time" type="time"
                                    class="block mt-1 w-full" :value="old('interview_time')" required />
                                <x-input-error :messages="$errors->get('interview_time')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="mode" :value="__('Mode')" />
                            <select id="mode" name="mode" required x-model="mode"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="online" {{ old('mode') === 'online' ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ old('mode') === 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                            <x-input-error :messages="$errors->get('mode')" class="mt-2" />
                        </div>

                        <div x-show="mode === 'online'" x-transition>
                            <x-input-label for="meeting_link" :value="__('Meeting link (if online)')" />
                            <x-text-input id="meeting_link" name="meeting_link" type="text" class="block mt-1 w-full"
                                placeholder="https://meet.google.com/..." :value="old('meeting_link')" />
                            <x-input-error :messages="$errors->get('meeting_link')" class="mt-2" />
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('company.jobs.applicants', $application->job_post_id) }}"
                        class="text-xs font-semibold text-gray-500">Cancel</a>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-calendar-check mr-2"></i>{{ __('Schedule interview') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        {{-- Right: candidate summary + tips --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Candidate</p>
                    </div>
                    <div class="p-5">
                        <div
                            class="w-11 h-11 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-sm mb-3">
                            {{ strtoupper(substr($application->candidate->user->name, 0, 2)) }}
                        </div>
                        <p class="font-bold text-sm mb-1">{{ $application->candidate->user->name }}</p>
                        <p class="text-xs text-gray-400 mb-3">{{ $application->candidate->user->email }}</p>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-green-50 text-green-700">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Applying for</p>
                    </div>
                    <div class="p-5">
                        <p class="font-bold text-sm mb-1">{{ $application->jobPost->job_title }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $application->jobPost->location ?: 'Location not set' }}
                            &middot; {{ ucfirst(str_replace('_', ' ', $application->jobPost->job_type)) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            Applied {{ $application->applied_date->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tips</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Give candidates at least 24 hours' notice when
                                possible.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Double-check the meeting link works before
                                sending it out.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
