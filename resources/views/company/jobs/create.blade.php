@extends('layouts.dashboard')

@section('page-title', 'Post a Job')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Post a new job</h1>
    <p class="text-gray-500 text-sm mb-6">Fill in the details candidates will see</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ title: '', type: '', location: '', salary: '' }">

        {{-- Left: form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('company.jobs.store') }}" class="space-y-6">
                @csrf

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Job details</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div>
                            <x-input-label for="job_title" :value="__('Job title')" />
                            <x-text-input id="job_title" name="job_title" type="text" class="block mt-1 w-full"
                                placeholder="e.g. Laravel Developer" :value="old('job_title')" required
                                x-model="title" />
                            <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="job_description" :value="__('Job description')" />
                            <textarea id="job_description" name="job_description" rows="5" required
                                placeholder="Describe the role, responsibilities, and requirements..."
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('job_description') }}</textarea>
                            <x-input-error :messages="$errors->get('job_description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input-label for="job_type" :value="__('Job type')" />
                                <select id="job_type" name="job_type" required x-model="type"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                    <option value="">Select type</option>
                                    <option value="full_time" {{ old('job_type') === 'full_time' ? 'selected' : '' }}>Full time</option>
                                    <option value="part_time" {{ old('job_type') === 'part_time' ? 'selected' : '' }}>Part time</option>
                                    <option value="contract" {{ old('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('job_type') === 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="experience" :value="__('Experience required')" />
                                <x-text-input id="experience" name="experience" type="text" class="block mt-1 w-full"
                                    placeholder="e.g. 1-3 Years" :value="old('experience')" />
                                <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Compensation & location</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="salary" :value="__('Salary (annual, ₹)')" />
                            <x-text-input id="salary" name="salary" type="number" class="block mt-1 w-full"
                                placeholder="500000" :value="old('salary')" x-model="salary" />
                            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" name="location" type="text" class="block mt-1 w-full"
                                placeholder="e.g. Noida / Remote" :value="old('location')" x-model="location" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="vacancies" :value="__('Vacancies')" />
                            <x-text-input id="vacancies" name="vacancies" type="number" class="block mt-1 w-full"
                                value="{{ old('vacancies', 1) }}" required min="1" />
                            <x-input-error :messages="$errors->get('vacancies')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="last_date" :value="__('Application deadline')" />
                            <x-text-input id="last_date" name="last_date" type="date" class="block mt-1 w-full"
                                :value="old('last_date')" />
                            <x-input-error :messages="$errors->get('last_date')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('company.dashboard') }}" class="text-xs font-semibold text-gray-500">Cancel</a>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-check mr-2"></i>{{ __('Post job') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        {{-- Right: live preview + tips --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">How candidates see it</p>
                    </div>
                    <div class="p-5">
                        <p class="font-bold text-sm mb-1" x-text="title || 'Job title'"></p>
                        <p class="text-xs text-gray-400 mb-3">
                            {{ auth()->user()->company->company_name }}
                            <template x-if="location"> &middot; <span x-text="location"></span></template>
                            <template x-if="type"> &middot; <span x-text="type"></span></template>
                        </p>
                        <template x-if="salary">
                            <p class="text-xs font-semibold text-violet-600">₹<span x-text="salary"></span> / year</p>
                        </template>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tips</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Clear job titles get more relevant applicants than vague ones.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Listing a salary range increases application rates significantly.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Be specific about required skills to reduce unqualified applicants.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection