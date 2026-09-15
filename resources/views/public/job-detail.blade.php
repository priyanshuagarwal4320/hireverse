<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireVerse - {{ $job->job_title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50" style="font-family:'Inter',sans-serif;">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('public.jobs') }}" class="flex items-center gap-2">
                <svg width="28" height="28" viewBox="0 0 100 100">
                    <rect width="100" height="100" rx="24" fill="#171a2e" />
                    <rect x="27" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
                    <rect x="62" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
                    <path d="M50 36 L61 50 L50 64 L39 50 Z" fill="#fff" />
                </svg>
                <span class="font-extrabold" style="font-family:'Manrope',sans-serif;">Hire<span
                        style="color:#6c5ce7;">Verse</span></span>
            </a>
            <div class="flex gap-3 text-sm font-semibold">
                <a href="{{ route('login') }}" class="text-gray-600 px-4 py-2">Login</a>
                <a href="{{ route('register') }}" class="text-white px-4 py-2 rounded-lg"
                    style="background:#171a2e;">Sign up</a>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <a href="{{ route('public.jobs') }}" class="text-xs font-semibold text-gray-500">&larr; Back to all jobs</a>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 mt-4">
            <div class="flex items-center gap-4 mb-6">
                @if ($job->company->logo)
                    <img src="{{ asset('storage/' . $job->company->logo) }}" class="w-14 h-14 rounded-xl object-cover">
                @else
                    <div
                        class="w-14 h-14 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-xl">
                        {{ strtoupper(substr($job->company->company_name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-xl font-extrabold" style="font-family:'Manrope',sans-serif;">{{ $job->job_title }}
                    </h1>
                    <p class="text-sm text-gray-500">{{ $job->company->company_name }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        <i class="fas fa-eye"></i> Viewed by {{ number_format($job->views_count) }} {{ Str::plural('person', $job->views_count) }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 font-semibold">Location</p>
                    <p class="text-sm font-bold">{{ $job->location ?: 'Remote' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold">Type</p>
                    <p class="text-sm font-bold">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold">Experience</p>
                    <p class="text-sm font-bold">{{ $job->experience ?: 'Not specified' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold">Salary</p>
                    <p class="text-sm font-bold">
                        {{ $job->salary ? '₹' . number_format($job->salary) : 'Not disclosed' }}</p>
                </div>
            </div>

            <h3 class="text-sm font-bold mb-2">Job description</h3>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line mb-6">{{ $job->job_description }}</p>

            @if ($job->company->about)
                <h3 class="text-sm font-bold mb-2">About {{ $job->company->company_name }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $job->company->about }}</p>
            @endif

            <a href="{{ route('register') }}" class="inline-block text-sm font-bold text-white px-6 py-3 rounded-lg"
                style="background:#171a2e;">
                Sign up to apply
            </a>
            <p class="text-xs text-gray-500 mt-3">
                <i class="fas fa-users"></i> {{ $job->applications_count }} {{ Str::plural('applicant', $job->applications_count) }} so far
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 mt-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold">Company reviews</h3>
                @if ($job->company->reviews()->count() > 0)
                    <span class="text-sm font-bold text-amber-500">
                        <i class="fas fa-star"></i> {{ $job->company->averageRating() }}
                        <span class="text-gray-400 font-normal">({{ $job->company->reviews()->count() }})</span>
                    </span>
                @endif
            </div>

            @forelse ($job->company->reviews()->latest()->get() as $review)
                <div class="border-b border-gray-100 last:border-0 py-3">
                    <div class="flex items-center gap-1 mb-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <i
                                class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                        @endfor
                    </div>
                    @if ($review->review)
                        <p class="text-sm text-gray-600">{{ $review->review }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-400">No reviews yet.</p>
            @endforelse
        </div>

        @if ($similarJobs->count() > 0)
            <div class="mt-6">
                <h3 class="text-sm font-bold mb-3">Similar jobs</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($similarJobs as $similarJob)
                        <a href="{{ route('public.job.show', $similarJob) }}"
                            class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:border-violet-400 block">
                            <p class="font-bold text-sm mb-1">{{ $similarJob->job_title }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $similarJob->company->company_name }}
                                @if ($similarJob->location)
                                    &middot; {{ $similarJob->location }}
                                @endif
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</body>

</html>