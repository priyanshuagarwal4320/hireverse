<x-guest-layout>

    <h1 class="text-xl font-extrabold mb-1">Create your HireVerse account</h1>
    <div class="w-12 h-1 rounded-full mb-6" style="background:#6c5ce7;"></div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-3">
            <div>
                <x-input-label for="name" :value="__('Full name')" />
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                        <i class="fas fa-user"></i>
                    </span>
                    <x-text-input id="name" class="block w-full pl-9" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" placeholder="Your name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email address')" />
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <x-text-input id="email" class="block w-full pl-9" type="email" name="email" :value="old('email')"
                        required autocomplete="username" placeholder="you@company.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label :value="__('I am a...')" />
            <div class="grid grid-cols-2 gap-3 mt-1">
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="candidate" class="peer sr-only" required
                        {{ old('role') === 'candidate' ? 'checked' : '' }}>
                    <div class="border rounded-lg p-2 text-center peer-checked:border-2" style="border-color:#e3e7ee;"
                        onclick="this.closest('label').querySelector('input').checked=true">
                        <i class="fas fa-user-tie text-gray-400 mb-1"></i>
                        <p class="text-xs font-bold">Candidate</p>
                        <p class="text-[10px] text-gray-400">Looking for a job</p>
                    </div>
                </label>
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="company" class="peer sr-only"
                        {{ old('role') === 'company' ? 'checked' : '' }}>
                    <div class="border rounded-lg p-2 text-center peer-checked:border-2" style="border-color:#e3e7ee;"
                        onclick="this.closest('label').querySelector('input').checked=true">
                        <i class="fas fa-building text-gray-400 mb-1"></i>
                        <p class="text-xs font-bold">Company</p>
                        <p class="text-[10px] text-gray-400">Hiring candidates</p>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                        <i class="fas fa-lock"></i>
                    </span>
                    <x-text-input id="password" class="block w-full pl-9" type="password" name="password" required
                        autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm')" />
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                        <i class="fas fa-lock"></i>
                    </span>
                    <x-text-input id="password_confirmation" class="block w-full pl-9" type="password"
                        name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <button type="submit" class="w-full text-white font-bold text-sm rounded-lg py-3 mt-2" style="background:#171a2e;">
            {{ __('Create account') }}
        </button>

        <div class="flex justify-center gap-2 text-xs font-semibold pt-1">
            <span class="text-gray-400">Already have an account?</span>
            <a href="{{ route('login') }}" style="color:#6c5ce7;">Login</a>
        </div>
    </form>

</x-guest-layout>