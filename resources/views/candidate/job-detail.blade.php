@extends('layouts.dashboard')

@section('page-title', $job->job_title)

@section('content')

    <a href="{{ route('candidate.dashboard') }}" class="text-xs font-semibold text-gray-500">&larr; Back to jobs</a>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 mt-4 max-w-3xl">
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
                <h1 class="text-xl font-extrabold">{{ $job->job_title }}</h1>
                <p class="text-sm text-gray-500">{{ $job->company->company_name }}</p>
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
                <p class="text-sm font-bold">{{ $job->salary ? '₹' . number_format($job->salary) : 'Not disclosed' }}</p>
            </div>
        </div>

        <h3 class="text-sm font-bold mb-2">Job description</h3>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line mb-6">{{ $job->job_description }}</p>

        @if ($job->company->about)
            <h3 class="text-sm font-bold mb-2">About {{ $job->company->company_name }}</h3>
            <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $job->company->about }}</p>
        @endif

        <div class="flex items-center gap-3">
            @if ($alreadyApplied)
                <span class="inline-block text-sm font-bold px-6 py-3 rounded-lg bg-green-50 text-green-700">
                    <i class="fas fa-check-circle mr-1"></i> Already applied
                </span>
            @else
                <form method="POST" action="{{ route('applications.store', $job) }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-white px-6 py-3 rounded-lg"
                        style="background:#171a2e;">
                        Apply now
                    </button>
                </form>
            @endif

            @if ($isSaved)
                <form method="POST" action="{{ route('jobs.unsave', $job) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-sm font-bold px-6 py-3 rounded-lg border border-violet-200 text-violet-700 bg-violet-50">
                        <i class="fas fa-bookmark mr-1"></i> Saved
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('jobs.save', $job) }}">
                    @csrf
                    <button type="submit"
                        class="text-sm font-bold px-6 py-3 rounded-lg border border-gray-200 text-gray-600">
                        <i class="far fa-bookmark mr-1"></i> Save job
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 mt-4 max-w-3xl">
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

        @if (auth()->user()->candidate?->canReviewCompany($job->company_id))
            <form method="POST" action="{{ route('reviews.store', $job->company) }}"
                class="mt-4 pt-4 border-t border-gray-100">
                @csrf
                <label class="text-xs font-bold text-gray-500 mb-1 block">Rate this company</label>
                <select name="rating" required class="border-gray-300 rounded-md shadow-sm text-sm mb-2">
                    <option value="">Select rating</option>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Below average</option>
                    <option value="1">1 - Poor</option>
                </select>
                <textarea name="review" rows="2" placeholder="Share your experience (optional)"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mb-2"></textarea>
                <button type="submit" class="text-xs font-bold px-4 py-2 rounded-lg bg-gray-900 text-white">
                    Submit review
                </button>
            </form>
        @endif
    </div>

    @if ($similarJobs->count() > 0)
        <div class="mt-6 max-w-3xl">
            <h3 class="text-sm font-bold mb-3">Similar jobs</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ($similarJobs as $similarJob)
                    <a href="{{ route('candidate.job.detail', $similarJob) }}"
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

@endsection
