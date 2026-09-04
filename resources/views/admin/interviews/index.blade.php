@extends('layouts.dashboard')

@section('page-title', 'Interviews')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Interviews</h1>
    <p class="text-gray-500 text-sm mb-6">All scheduled interviews across the platform</p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Candidate</th>
                    <th class="px-5 py-3">Job</th>
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Date</th>
                    <th class="px-5 py-3">Time</th>
                    <th class="px-5 py-3">Mode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interviews as $interview)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $interview->application->candidate->user->name }}</td>
                        <td class="px-5 py-3">{{ $interview->application->jobPost->job_title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $interview->application->jobPost->company->company_name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $interview->interview_date->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $interview->mode === 'online' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ ucfirst($interview->mode) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400">No interviews scheduled yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $interviews->links() }}
    </div>

@endsection