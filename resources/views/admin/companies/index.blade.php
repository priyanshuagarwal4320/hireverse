@extends('layouts.dashboard')

@section('page-title', 'Companies')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Companies</h1>
    <p class="text-gray-500 text-sm mb-6">All registered companies on the platform</p>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Industry</th>
                    <th class="px-5 py-3">Jobs posted</th>
                    <th class="px-5 py-3">Joined</th>
                    <th class="px-5 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">{{ $company->company_name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $company->user->email }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $company->industry ?: '—' }}</td>
                        <td class="px-5 py-3">{{ $company->job_posts_count }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $company->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.companies.destroy', $company) }}"
                                onsubmit="return confirm('This will permanently delete this company and all its jobs, applications, interviews, and results. Continue?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            No companies registered yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $companies->links() }}
    </div>

@endsection
