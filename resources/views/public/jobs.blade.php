<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireVerse - Browse Jobs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" style="font-family:'Inter',sans-serif;">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg width="28" height="28" viewBox="0 0 100 100">
                    <rect width="100" height="100" rx="24" fill="#171a2e"/>
                    <rect x="27" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7"/>
                    <rect x="62" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7"/>
                    <path d="M50 36 L61 50 L50 64 L39 50 Z" fill="#fff"/>
                </svg>
                <span class="font-extrabold" style="font-family:'Manrope',sans-serif;">Hire<span style="color:#6c5ce7;">Verse</span></span>
            </div>
            <div class="flex gap-3 text-sm font-semibold">
                <a href="{{ route('login') }}" class="text-gray-600 px-4 py-2">Login</a>
                <a href="{{ route('register') }}" class="text-white px-4 py-2 rounded-lg" style="background:#171a2e;">Sign up</a>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-extrabold mb-1" style="font-family:'Manrope',sans-serif;">Find your next opportunity</h1>
        <p class="text-gray-500 text-sm mb-6">{{ $jobs->total() }} open positions across {{ $jobs->pluck('company.company_name')->unique()->count() }} companies</p>

        <form method="GET" action="{{ route('public.jobs') }}" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-8 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by job title or location..."
                    class="block w-full pl-9 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            </div>
                        <select name="job_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <option value="">All types</option>
                <option value="full_time" {{ request('job_type') === 'full_time' ? 'selected' : '' }}>Full time</option>
                <option value="part_time" {{ request('job_type') === 'part_time' ? 'selected' : '' }}>Part time</option>
                <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                <option value="internship" {{ request('job_type') === 'internship' ? 'selected' : '' }}>Internship</option>
            </select>
            <select name="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <option value="">All categories</option>
                <option value="Engineering" {{ request('category') === 'Engineering' ? 'selected' : '' }}>Engineering</option>
                <option value="Design" {{ request('category') === 'Design' ? 'selected' : '' }}>Design</option>
                <option value="Sales" {{ request('category') === 'Sales' ? 'selected' : '' }}>Sales</option>
                <option value="Marketing" {{ request('category') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="Customer Support" {{ request('category') === 'Customer Support' ? 'selected' : '' }}>Customer Support</option>
                <option value="HR" {{ request('category') === 'HR' ? 'selected' : '' }}>HR</option>
                <option value="Finance" {{ request('category') === 'Finance' ? 'selected' : '' }}>Finance</option>
                <option value="Other" {{ request('category') === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <button type="submit" class="text-xs font-bold px-5 py-2 rounded-lg text-white" style="background:#171a2e;">Search</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($jobs as $job)
                <a href="{{ route('public.job.show', $job) }}" class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition block">
                    <div class="flex items-center gap-3 mb-3">
                        @if($job->company->logo)
                            <img src="{{ asset('storage/' . $job->company->logo) }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-violet-600 text-white flex items-center justify-center font-extrabold text-sm">
                                {{ strtoupper(substr($job->company->company_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-sm">{{ $job->job_title }}</p>
                            <p class="text-xs text-gray-400">{{ $job->company->company_name }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mb-3">
                        {{ $job->location ?: 'Remote' }} &middot; {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}
                        @if($job->salary) &middot; &#8377;{{ number_format($job->salary) }} @endif
                    </p>
                    <span class="text-xs font-bold text-violet-600">View details &rarr;</span>
                </a>
            @empty
                <div class="col-span-3 bg-white border border-gray-200 rounded-2xl p-10 text-center text-gray-400 text-sm">
                    No jobs found matching your search.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>

    <footer class="text-center text-xs text-gray-400 py-6">
        HireVerse — Where talent meets opportunity
    </footer>

</body>
</html>
