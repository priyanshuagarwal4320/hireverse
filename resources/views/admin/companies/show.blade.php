@extends('layouts.dashboard')

@section('page-title', $company->company_name)

@section('content')

    <a href="{{ route('admin.companies.index') }}" class="text-xs font-semibold text-gray-500">&larr; Back to companies</a>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 mt-4 max-w-3xl">
        <div class="flex items-center gap-4 mb-6">
            @if ($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="w-16 h-16 rounded-xl object-cover">
            @else
                <div class="w-16 h-16 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-2xl">
                    {{ strtoupper(substr($company->company_name, 0, 1)) }}
                </div>
            @endif
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-extrabold">{{ $company->company_name }}</h1>
                    <span class="text-xs font-bold px-3 py-1 rounded-full
                        {{ $company->is_verified ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $company->is_verified ? 'Verified' : 'Unverified' }}
                    </span>
                </div>
                <p class="text-sm text-gray-500">{{ $company->user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100">
            <div>
                <p class="text-xs text-gray-400 font-semibold">Industry</p>
                <p class="text-sm font-bold">{{ $company->industry ?: 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">Phone</p>
                <p class="text-sm font-bold">{{ $company->phone ?: 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold">Website</p>
                <p class="text-sm font-bold">
                    @if ($company->website)
                        <a href="{{ $company->website }}" target="_blank" class="text-violet-600">{{ $company->website }}</a>
                    @else
                        Not specified
                    @endif
                </p>
            </div>
        </div>

        <h3 class="text-sm font-bold mb-2">Address</h3>
        <p class="text-sm text-gray-600 mb-6">{{ $company->address ?: 'Not specified' }}</p>

        <h3 class="text-sm font-bold mb-2">About</h3>
        <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $company->about ?: 'Not specified' }}</p>

        <h3 class="text-sm font-bold mb-2">Jobs posted ({{ $company->jobPosts->count() }})</h3>
        @forelse ($company->jobPosts as $job)
            <p class="text-sm text-gray-600 mb-1">&bull; {{ $job->job_title }} ({{ ucfirst($job->status) }})</p>
        @empty
            <p class="text-sm text-gray-400">No jobs posted yet.</p>
        @endforelse

        <div class="mt-6 pt-6 border-t border-gray-100">
            <form method="POST" action="{{ route('admin.companies.toggle-verification', $company) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-sm font-bold px-6 py-3 rounded-lg text-white" style="background:#171a2e;">
                    {{ $company->is_verified ? 'Unverify this company' : 'Verify this company' }}
                </button>
            </form>
        </div>
    </div>

@endsection