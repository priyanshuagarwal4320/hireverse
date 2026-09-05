<x-guest-layout>

    <h1 class="text-xl font-extrabold mb-1">Login to your HireVerse account</h1>
    <div class="w-12 h-1 rounded-full mb-6" style="background:#6c5ce7;"></div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <div class="relative mt-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-envelope"></i>
                </span>
                <x-text-input id="email" class="block w-full pl-9" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username"
                    placeholder="you@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password" class="block w-full pl-9" type="password" name="password"
                    required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-violet-600 shadow-sm focus:ring-violet-500" name="remember">
                <span class="ms-2 text-xs text-gray-500 font-medium">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-xs font-semibold" style="color:#b5432f;" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full text-white font-bold text-sm rounded-lg py-3 mt-2" style="background:#171a2e;">
            {{ __('Login') }}
        </button>

        <div class="flex justify-center gap-5 text-xs font-semibold pt-2">
            <a href="{{ route('register') }}" class="text-gray-500">{{ __('Sign up') }}</a>
        </div>
    </form>

</x-guest-layout>