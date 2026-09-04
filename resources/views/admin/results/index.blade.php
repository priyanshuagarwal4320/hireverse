@extends('layouts.dashboard')

@section('page-title', 'Results')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Results</h1>
    <p class="text-gray-500 text-sm mb-6">All interview results across the platform</p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Candidate</th>
                    <th class="px-5 py-3">Job</th>
                    <th class="px-5 py-3">Score</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $result->interview->application->candidate->user->name }}</td>
                        <td class="px-5 py-3">{{ $result->interview->application->jobPost->job_title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $result->score ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $result->status === 'pass' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst($result->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-400">No results recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $results->links() }}
    </div>

@endsection