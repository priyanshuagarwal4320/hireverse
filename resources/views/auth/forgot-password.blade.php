<x-guest-layout>

    <h1 class="text-xl font-extrabold mb-1">Forgot your password?</h1>
    <div class="w-12 h-1 rounded-full mb-4" style="background:#6c5ce7;"></div>

    <p class="text-xs text-gray-500 leading-relaxed mb-6">
        {{ __('No problem. Just enter your email address and we will send you a password reset link.') }}
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <div class="relative mt-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-envelope"></i>
                </span>
                <x-text-input id="email" class="block w-full pl-9" type="email" name="email"
                    :value="old('email')" required autofocus placeholder="you@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full text-white font-bold text-sm rounded-lg py-3 mt-2" style="background:#171a2e;">
            {{ __('Email password reset link') }}
        </button>

        <div class="flex justify-center gap-2 text-xs font-semibold pt-1">
            <a href="{{ route('login') }}" style="color:#6c5ce7;">
                <i class="fas fa-arrow-left mr-1"></i>{{ __('Back to login') }}
            </a>
        </div>
    </form>

</x-guest-layout>