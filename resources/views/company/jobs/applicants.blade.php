@extends('layouts.dashboard')

@section('page-title', 'Applicants')

@section('content')

    <div class="mb-6">
        <a href="{{ route('company.jobs.index') }}" class="text-xs font-semibold text-gray-500">&larr; Back to My Jobs</a>
        <h1 class="text-xl font-extrabold mt-2 mb-1">Applicants for "{{ $job->job_title }}"</h1>
        <p class="text-gray-500 text-sm">{{ $applications->count() }} candidate(s) have applied</p>
    </div>

    @if (session('status'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Candidate</th>
                    <th class="px-5 py-3">Applied</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $application->candidate->user->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $application->applied_date->format('d M Y') }}</td>
                        <td class="px-5 py-3">
                            <span
                                class="text-xs font-bold px-3 py-1 rounded-full
                                @if ($application->status === 'pending') bg-amber-50 text-amber-700
                                @elseif($application->status === 'shortlisted') bg-violet-50 text-violet-700
                                @elseif($application->status === 'selected') bg-green-50 text-green-700
                                @else bg-red-50 text-red-700 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <form method="POST" action="{{ route('applications.update-status', $application) }}"
                                    class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="shortlisted"
                                            {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted
                                        </option>
                                        <option value="selected"
                                            {{ $application->status === 'selected' ? 'selected' : '' }}>Selected</option>
                                        <option value="rejected"
                                            {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </form>

                                @if (in_array($application->status, ['shortlisted', 'selected']))
                                    @if ($application->interview)
                                        <span class="text-xs font-semibold text-green-600">
                                            <i class="fas fa-check-circle"></i> Interview set
                                        </span>
                                        @if ($application->interview->result)
                                            <span class="text-xs font-semibold text-violet-600">
                                                <i class="fas fa-poll"></i> Result: {{ ucfirst($application->interview->result->status) }}
                                            </span>
                                        @else
                                            <a href="{{ route('results.create', $application->interview) }}"
                                                class="text-xs font-semibold text-amber-600">
                                                Record result
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('interviews.create', $application) }}"
                                            class="text-xs font-semibold text-blue-600">
                                            Schedule interview
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-400">
                            No applicants yet for this job.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection