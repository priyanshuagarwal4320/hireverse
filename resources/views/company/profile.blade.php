@extends('layouts.dashboard')

@section('page-title', 'Company Profile')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">Company profile</h1>
    <p class="text-gray-500 text-sm mb-6">Update your company's public information</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: form (takes 2 of 3 columns) --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-bold">Profile completeness</p>
                    <p class="text-sm font-extrabold text-violet-600">{{ $completeness }}%</p>
                </div>
                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-violet-600 rounded-full transition-all duration-500" style="width: {{ $completeness }}%"></div>
                </div>
                @if($completeness < 100)
                    <p class="text-xs text-gray-400 mt-2">Complete your profile to appear more credible to candidates.</p>
                @endif
            </div>

            @if (session('status'))
                <div class="px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('company.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                            <i class="fas fa-building text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">Basic information</h3>
                            <p class="text-xs text-gray-400">Your company's name and industry</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <x-input-label for="company_name" :value="__('Company name')" />
                            <x-text-input id="company_name" name="company_name" type="text" class="block mt-1 w-full"
                                :value="old('company_name', $company->company_name)" required />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="industry" :value="__('Industry')" />
                            <x-text-input id="industry" name="industry" type="text" class="block mt-1 w-full"
                                placeholder="e.g. Software / IT Services"
                                :value="old('industry', $company->industry)" />
                            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="block mt-1 w-full"
                                :value="old('phone', $company->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">Contact & location</h3>
                            <p class="text-xs text-gray-400">Where candidates can find or reach you</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="text" class="block mt-1 w-full"
                                placeholder="https://example.com"
                                :value="old('website', $company->website)" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" name="address" type="text" class="block mt-1 w-full"
                                :value="old('address', $company->address)" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fas fa-align-left text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">About the company</h3>
                            <p class="text-xs text-gray-400">Shown to candidates on your job listings</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <textarea id="about" name="about" rows="5"
                            placeholder="Tell candidates what your company does and what makes it a great place to work..."
                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('about', $company->about) }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-400">Changes are visible to candidates immediately.</p>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-check mr-2"></i>{{ __('Save changes') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        {{-- Right: live preview + tips (sticky) --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                {{-- Preview card --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">How candidates see you</p>
                    </div>
                    <div class="p-5">
                        <div class="w-12 h-12 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-lg mb-3">
                            {{ strtoupper(substr($company->company_name ?? 'C', 0, 1)) }}
                        </div>
                        <p class="font-bold text-sm mb-1">{{ $company->company_name ?: 'Your company name' }}</p>
                        <p class="text-xs text-gray-400 mb-3">
                            {{ $company->industry ?: 'Industry not set' }}
                            @if($company->address) &middot; {{ Str::limit($company->address, 25) }} @endif
                        </p>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            {{ $company->about ? Str::limit($company->about, 120) : 'Add a short description so candidates know what your company does.' }}
                        </p>
                        @if($company->website)
                            <a href="#" class="inline-flex items-center gap-1 text-xs font-bold text-violet-600 mt-3">
                                <i class="fas fa-link text-[10px]"></i> {{ $company->website }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Tips card --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tips</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">A complete profile gets more applicants than a bare one.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">Keep "About" short and specific — mention your tech stack or team size.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">A real website link builds trust with candidates.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
