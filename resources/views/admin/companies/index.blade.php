@extends('layouts.dashboard')

@section('page-title', 'Companies')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Companies</h1>
    <p class="text-gray-500 text-sm mb-6">All registered companies on the platform</p>

    <form method="GET" action="{{ route('admin.companies.index') }}" class="mb-4">
    <div class="relative max-w-sm">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
            <i class="fas fa-search"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search companies..."
    onkeyup="clearTimeout(window.searchTimeout); window.searchTimeout = setTimeout(() => this.form.submit(), 500);"
    class="block w-full pl-9 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
    </div>
</form>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-400 uppercase font-bold bg-gray-50">
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Industry</th>
                    <th class="px-5 py-3">Jobs posted</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Joined</th>
                    <th class="px-5 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr class="border-t border-gray-100">
                        <td class="px-5 py-3 font-semibold">
                            {{ $company->company_name }}
                            @if ($company->is_verified)
                                <i class="fas fa-circle-check text-blue-500 text-xs" title="Verified"></i>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $company->user->email }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $company->industry ?: '—' }}</td>
                        <td class="px-5 py-3">{{ $company->job_posts_count }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full
                                {{ $company->is_verified ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $company->is_verified ? 'Verified' : 'Unverified' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $company->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.companies.show', $company) }}" class="text-xs font-semibold text-gray-500">View</a>
                                <form method="POST" action="{{ route('admin.companies.toggle-verification', $company) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-semibold text-violet-600">
                                        {{ $company->is_verified ? 'Unverify' : 'Verify' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.companies.destroy', $company) }}"
                                    onsubmit="return confirm('This will permanently delete this company and all its jobs, applications, interviews, and results. Continue?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-600">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-400">
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