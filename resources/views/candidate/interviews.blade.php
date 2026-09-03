@extends('layouts.dashboard')

@section('page-title', 'My Interviews')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">My interviews</h1>
    <p class="text-gray-500 text-sm mb-6">Scheduled interviews for your applications</p>

    <div class="space-y-4">
        @forelse($interviews as $interview)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-bold text-sm mb-1">{{ $interview->application->jobPost->job_title }}</h3>
                        <p class="text-xs text-gray-400">{{ $interview->application->jobPost->company->company_name }}</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full
                        {{ $interview->mode === 'online' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ ucfirst($interview->mode) }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Date</p>
                        <p class="text-sm font-semibold">{{ $interview->interview_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Time</p>
                        <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</p>
                    </div>
                </div>
                @if($interview->mode === 'online' && $interview->meeting_link)
                    <a href="{{ $interview->meeting_link }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-violet-600 mt-3">
                        <i class="fas fa-video"></i> Join meeting
                    </a>
                @endif
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                No interviews scheduled yet.
            </div>
        @endforelse
    </div>

@endsection