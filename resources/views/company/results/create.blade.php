@extends('layouts.dashboard')

@section('page-title', 'Record Result')

@section('content')

    <div class="mb-6">
        <a href="{{ route('company.jobs.applicants', $interview->application->job_post_id) }}" class="text-xs font-semibold text-gray-500">&larr; Back to Applicants</a>
        <h1 class="text-xl font-extrabold mt-2 mb-1">Record interview result</h1>
        <p class="text-gray-500 text-sm">
            For <strong>{{ $interview->application->candidate->user->name }}</strong> — {{ $interview->application->jobPost->job_title }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('results.store', $interview) }}" class="space-y-6">
                @csrf

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Result details</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div>
                            <x-input-label for="status" :value="__('Result')" />
                            <select id="status" name="status" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="pass" {{ old('status') === 'pass' ? 'selected' : '' }}>Pass</option>
                                <option value="fail" {{ old('status') === 'fail' ? 'selected' : '' }}>Fail</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="score" :value="__('Score (out of 100, optional)')" />
                            <x-text-input id="score" name="score" type="number" class="block mt-1 w-full"
                                placeholder="85" min="0" max="100" :value="old('score')" />
                            <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <textarea id="remarks" name="remarks" rows="6"
                                placeholder="Feedback about the candidate's performance..."
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('remarks') }}</textarea>
                            <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('company.jobs.applicants', $interview->application->job_post_id) }}" class="text-xs font-semibold text-gray-500">Cancel</a>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-check mr-2"></i>{{ __('Save result') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        {{-- Right: candidate + interview context --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Candidate</p>
                    </div>
                    <div class="p-5">
                        <div class="w-11 h-11 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-sm mb-3">
                            {{ strtoupper(substr($interview->application->candidate->user->name, 0, 2)) }}
                        </div>
                        <p class="font-bold text-sm mb-1">{{ $interview->application->candidate->user->name }}</p>
                        <p class="text-xs text-gray-400 mb-3">{{ $interview->application->candidate->user->email }}</p>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-green-50 text-green-700">
                            {{ ucfirst($interview->application->status) }}
                        </span>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Interview details</p>
                    </div>
                    <div class="p-5 space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400">Job</span>
                            <span class="font-semibold">{{ $interview->application->jobPost->job_title }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400">Date</span>
                            <span class="font-semibold">{{ $interview->interview_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400">Time</span>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400">Mode</span>
                            <span class="font-semibold">{{ ucfirst($interview->mode) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tips</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Specific remarks help future hiring decisions more than a generic pass/fail.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">This result is visible to the candidate once saved.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection