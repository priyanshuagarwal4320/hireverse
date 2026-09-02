@extends('layouts.dashboard')

@section('page-title', 'Edit Job')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Edit job</h1>
    <p class="text-gray-500 text-sm mb-6">Update the details for "{{ $job->job_title }}"</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{
        title: '{{ $job->job_title }}',
        type: '{{ ucfirst(str_replace('_', '', $job->job_type)) }}',
        location: '{{ $job->location }}',
        salary: '{{ $job->salary }}'
    }">

        {{-- Left: form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('company.jobs.update', $job) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Job details</h3>
                    </div>
                    <div class="p-6 space-y-5">

                        <div>
                            <x-input-label for="job_title" :value="__('Job title')" />
                            <x-text-input id="job_title" name="job_title" type="text" class="block mt-1 w-full"
                                :value="old('job_title', $job->job_title)" required x-model="title" />
                            <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="job_description" :value="__('Job description')" />
                            <textarea id="job_description" name="job_description" rows="5" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('job_description', $job->job_description) }}</textarea>
                            <x-input-error :messages="$errors->get('job_description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input-label for="job_type" :value="__('Job type')" />
                                <select id="job_type" name="job_type" required x-model="type"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                    @php $currentType = old('job_type', $job->job_type); @endphp
                                    <option value="full_time" {{ $currentType === 'full_time' ? 'selected' : '' }}>Full time
                                    </option>
                                    <option value="part_time" {{ $currentType === 'part_time' ? 'selected' : '' }}>Part time
                                    </option>
                                    <option value="contract" {{ $currentType === 'contract' ? 'selected' : '' }}>Contract
                                    </option>
                                    <option value="internship" {{ $currentType === 'internship' ? 'selected' : '' }}>
                                        Internship</option>
                                </select>
                                <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="experience" :value="__('Experience required')" />
                                <x-text-input id="experience" name="experience" type="text" class="block mt-1 w-full"
                                    :value="old('experience', $job->experience)" />
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
                                :value="old('salary', $job->salary)" x-model="salary" />
                            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" name="location" type="text" class="block mt-1 w-full"
                                :value="old('location', $job->location)" x-model="location" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="vacancies" :value="__('Vacancies')" />
                            <x-text-input id="vacancies" name="vacancies" type="number" class="block mt-1 w-full"
                                :value="old('vacancies', $job->vacancies)" required min="1" />
                            <x-input-error :messages="$errors->get('vacancies')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="last_date" :value="__('Application deadline')" />
                            <x-text-input id="last_date" name="last_date" type="date" class="block mt-1 w-full"
                                :value="old('last_date', $job->last_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('last_date')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('company.jobs.index') }}" class="text-xs font-semibold text-gray-500">Cancel</a>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-check mr-2"></i>{{ __('Save changes') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        {{-- Right: live preview + job stats --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">How candidates see it</p>
                    </div>
                    <div class="p-5">
                        <p class="font-bold text-sm mb-1" x-text="title || 'Job title'"></p>
                        <p class="text-xs text-gray-400 mb-3">
                            {{ $job->company->company_name }}
                            <template x-if="location"><span> &middot; <span x-text="location"></span></span></template>
                            <template x-if="type"><span> &middot; <span x-text="type"></span></span></template>
                        </p>
                        <template x-if="salary">
                            <p class="text-xs font-semibold text-violet-600">₹<span x-text="salary"></span> / year</p>
                        </template>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Job status</p>
                    </div>
                    <div class="p-5">
                        <span
                            class="text-xs font-bold px-3 py-1 rounded-full
                            {{ $job->status === 'open' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-3">
                            Posted {{ $job->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
