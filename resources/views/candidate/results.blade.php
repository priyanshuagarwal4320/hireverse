@extends('layouts.dashboard')

@section('page-title', 'My Results')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">My results</h1>
    <p class="text-gray-500 text-sm mb-6">Outcomes from your completed interviews</p>

    <div class="space-y-4">
        @forelse($results as $result)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-bold text-sm mb-1">{{ $result->interview->application->jobPost->job_title }}</h3>
                        <p class="text-xs text-gray-400">{{ $result->interview->application->jobPost->company->company_name }}</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full
                        {{ $result->status === 'pass' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ ucfirst($result->status) }}
                    </span>
                </div>
                @if($result->score)
                    <p class="text-xs text-gray-500 mb-2"><strong>Score:</strong> {{ $result->score }} / 100</p>
                @endif
                @if($result->remarks)
                    <p class="text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3 mt-3">{{ $result->remarks }}</p>
                @endif
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                No results yet. Results appear here after your interviews.
            </div>
        @endforelse
    </div>

@endsection