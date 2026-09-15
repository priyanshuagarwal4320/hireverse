@extends('layouts.dashboard')

@section('page-title', 'My Profile')

@section('content')

    <h1 class="text-xl font-extrabold mb-1">My profile</h1>
    <p class="text-gray-500 text-sm mb-6">Keep your profile updated so companies can find you</p>
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-6">
        <p class="text-sm font-bold mb-2">Profile completeness: {{ $profileCompletion }}%</p>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-violet-600 h-2 rounded-full" style="width: {{ $profileCompletion }}%"></div>
        </div>
    </div>
    @if (session('status'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('candidate.profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Personal details</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="mobile" :value="__('Mobile number')" />
                            <x-text-input id="mobile" name="mobile" type="text" class="block mt-1 w-full"
                                :value="old('mobile', $candidate->mobile)" />
                            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="dob" :value="__('Date of birth')" />
                            <x-text-input id="dob" name="dob" type="date" class="block mt-1 w-full"
                                :value="old('dob', $candidate->dob?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @php $currentGender = old('gender', $candidate->gender); @endphp
                                <option value="">Select</option>
                                <option value="male" {{ $currentGender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $currentGender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $currentGender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input id="city" name="city" type="text" class="block mt-1 w-full"
                                :value="old('city', $candidate->city)" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Photo & resume</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <x-input-label for="profile_photo" :value="__('Profile photo')" />
                            @if($candidate->profile_photo)
                                <div class="flex items-center gap-3 mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $candidate->profile_photo) }}" class="w-14 h-14 rounded-xl object-cover">
                                    <span class="text-xs text-gray-400">Current photo</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-3 mt-1">
                                <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                                    class="block flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700" />
                                <button type="button" onclick="openCamera()"
                                    class="text-xs font-semibold px-3 py-2 rounded-md border border-gray-200 text-gray-600 whitespace-nowrap">
                                    <i class="fas fa-camera mr-1"></i> Take a photo
                                </button>
                            </div>

                            <div id="cameraBox" style="display:none;" class="mt-3 border border-gray-200 rounded-xl p-3 max-w-xs">
                                <video id="cameraPreview" autoplay playsinline class="w-full rounded-lg bg-gray-900"></video>
                                <canvas id="cameraCanvas" class="w-full rounded-lg" style="display:none;"></canvas>

                                <div class="flex items-center gap-2 mt-3">
                                    <button type="button" id="captureBtn" onclick="capturePhoto()"
                                        class="text-xs font-bold px-4 py-2 rounded-lg bg-gray-900 text-white">
                                        Capture
                                    </button>
                                    <button type="button" id="retakeBtn" onclick="retakePhoto()" style="display:none;"
                                        class="text-xs font-semibold px-4 py-2 rounded-lg border border-gray-200 text-gray-600">
                                        Retake
                                    </button>
                                    <button type="button" onclick="closeCamera()"
                                        class="text-xs font-semibold px-4 py-2 rounded-lg border border-gray-200 text-gray-600">
                                        Cancel
                                    </button>
                                </div>
                            </div>

                            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="resume" :value="__('Resume')" />
                            @if($candidate->resume)
                                <div class="flex items-center gap-2 mt-2 mb-2">
                                    <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank" class="text-xs font-semibold text-violet-600">
                                        <i class="fas fa-file-pdf"></i> View current resume
                                    </a>
                                </div>
                            @endif
                            <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx"
                                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-violet-50 file:text-violet-700" />
                            <x-input-error :messages="$errors->get('resume')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold">Professional details</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <x-input-label for="qualification" :value="__('Qualification')" />
                            <x-text-input id="qualification" name="qualification" type="text" class="block mt-1 w-full"
                                placeholder="e.g. B.Tech in Computer Science" :value="old('qualification', $candidate->qualification)" />
                            <x-input-error :messages="$errors->get('qualification')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="experience" :value="__('Experience')" />
                            <x-text-input id="experience" name="experience" type="text" class="block mt-1 w-full"
                                placeholder="e.g. 2 years" :value="old('experience', $candidate->experience)" />
                            <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="skills" :value="__('Skills')" />
                            <x-text-input id="skills" name="skills" type="text" class="block mt-1 w-full"
                                placeholder="e.g. Laravel, MySQL, Tailwind CSS" :value="old('skills', $candidate->skills)" />
                            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-400">Visible to companies when you apply.</p>
                    <x-primary-button class="!px-6">
                        <i class="fas fa-check mr-2"></i>{{ __('Save changes') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

        {{-- Right: live preview + tips --}}
        <div class="space-y-6">
            <div class="sticky top-6 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">How companies see you</p>
                    </div>
                    <div class="p-5">
                        @if($candidate->profile_photo)
                            <img src="{{ asset('storage/' . $candidate->profile_photo) }}" class="w-14 h-14 rounded-xl object-cover mb-3">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-violet-600 text-white flex items-center justify-center font-extrabold text-lg mb-3">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <p class="font-bold text-sm mb-1">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 mb-3">
                            {{ $candidate->qualification ?: 'Qualification not set' }}
                            @if($candidate->city) &middot; {{ $candidate->city }} @endif
                        </p>
                        @if($candidate->skills)
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $candidate->skills }}</p>
                        @endif
                        @if($candidate->resume)
                            <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-violet-600 mt-3">
                                <i class="fas fa-file-pdf"></i> Resume attached
                            </a>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tips</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">A photo and resume make companies more likely to shortlist you.</p>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-lightbulb text-amber-500 text-xs mt-0.5"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">List specific skills — it's how companies filter candidates.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        let cameraStream = null;

        function openCamera() {
            document.getElementById('cameraBox').style.display = 'block';
            document.getElementById('cameraPreview').style.display = 'block';
            document.getElementById('cameraCanvas').style.display = 'none';
            document.getElementById('captureBtn').style.display = 'inline-block';
            document.getElementById('retakeBtn').style.display = 'none';

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    cameraStream = stream;
                    document.getElementById('cameraPreview').srcObject = stream;
                })
                .catch(function () {
                    alert('Could not access camera. Please allow camera permission or use file upload instead.');
                    closeCamera();
                });
        }

        function capturePhoto() {
            const video = document.getElementById('cameraPreview');
            const canvas = document.getElementById('cameraCanvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            canvas.toBlob(function (blob) {
                const file = new File([blob], 'camera-photo.jpg', { type: 'image/jpeg' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('profile_photo').files = dataTransfer.files;
            }, 'image/jpeg', 0.9);

            video.style.display = 'none';
            canvas.style.display = 'block';
            document.getElementById('captureBtn').style.display = 'none';
            document.getElementById('retakeBtn').style.display = 'inline-block';

            if (cameraStream) {
                cameraStream.getTracks().forEach(function (track) { track.stop(); });
            }
        }

        function retakePhoto() {
            openCamera();
        }

        function closeCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(function (track) { track.stop(); });
                cameraStream = null;
            }
            document.getElementById('cameraBox').style.display = 'none';
        }
    </script>

@endsection