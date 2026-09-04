@extends('layouts.dashboard')

@section('page-title', 'Edit Result')

@section('content')

    <div class="mb-6">
        <a href="{{ route('company.interviews') }}" class="text-xs font-semibold text-gray-500">&larr; Back to Interviews</a>
        <h1 class="text-xl font-extrabold mt-2 mb-1">Edit interview result</h1>
        <p class="text-gray-500 text-sm">
            For <strong>{{ $interview->application->candidate->user->name }}</strong> — {{ $interview->application->jobPost->job_title }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('results.update', $interview) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Result details</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div>
                            <x-input-label for="status" :value="__('Result')" />
                            <select id="status" name="status" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @php $currentStatus = old('status', $interview->result->status); @endphp
                                <option value="pass" {{ $currentStatus === 'pass' ? 'selected' : '' }}>Pass</option>
                                <option value="fail" {{ $currentStatus === 'fail' ? 'selected' : '' }}>Fail</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="score" :value="__('Score (out of 100, optional)')" />
                            <x-text-input id="score" name="score" type="number" class="block mt-1 w-full"
                                min="0" max="100" :value="old('score', $interview->result->score)" />
                            <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <textarea id="remarks" name="remarks" rows="6"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('remarks', $interview->result->remarks) }}</textarea>
                            <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('company.interviews') }}" class="text-xs font-semibold text-gray-500">Cancel</a>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-check mr-2"></i>{{ __('Update result') }}
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
                        <span class="text-xs font-bold px-3 py-1 rounded-full
                            {{ $interview->application->status === 'selected' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
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
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Note</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex gap-2">
                            <i class="fas fa-info-circle text-blue-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Changing this result will automatically update the application's status too.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection