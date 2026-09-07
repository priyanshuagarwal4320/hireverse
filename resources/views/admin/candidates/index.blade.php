@extends('layouts.dashboard')

@section('page-title', 'Candidates')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Candidates</h1>
    <p class="text-gray-500 text-sm mb-6">All registered candidates on the platform</p>
<form method="GET" action="{{ route('admin.candidates.index') }}" class="mb-4">
    <div class="relative max-w-sm">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
            <i class="fas fa-search"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidates..."
    onkeyup="clearTimeout(window.searchTimeout); window.searchTimeout = setTimeout(() => this.form.submit(), 500);"
    class="block w-full pl-9 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
    </div>
</form>
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">City</th>
                    <th class="px-5 py-3">Applications</th>
                    <th class="px-5 py-3">Joined</th>
                    <th class="px-5 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidates as $candidate)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $candidate->user->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $candidate->user->email }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $candidate->city ?: '—' }}</td>
                        <td class="px-5 py-3">{{ $candidate->applications_count }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $candidate->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.candidates.destroy', $candidate) }}"
                                onsubmit="return confirm('This will permanently delete this candidate and all their applications, interviews, and results. Continue?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600">Delete</button>
                            </form>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            No candidates registered yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $candidates->links() }}
    </div>

@endsection