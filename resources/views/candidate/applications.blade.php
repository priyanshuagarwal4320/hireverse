@extends('layouts.dashboard')

@section('page-title', 'My Applications')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">My applications</h1>
    <p class="text-gray-500 text-sm mb-6">Track the status of every job you've applied to</p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Job title</th>
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Applied</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $application->jobPost->job_title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $application->jobPost->company->company_name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $application->applied_date->format('d M Y') }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full
                                @if($application->status === 'pending') bg-amber-50 text-amber-700
                                @elseif($application->status === 'shortlisted') bg-violet-50 text-violet-700
                                @elseif($application->status === 'selected') bg-green-50 text-green-700
                                @else bg-red-50 text-red-700
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-400">
                            You haven't applied to any jobs yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $applications->links() }}
    </div>

@endsection