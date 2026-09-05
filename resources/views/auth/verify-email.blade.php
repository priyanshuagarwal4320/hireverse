<x-guest-layout>

    <h1 class="text-xl font-extrabold mb-1">Verify your email</h1>
    <div class="w-12 h-1 rounded-full mb-4" style="background:#6c5ce7;"></div>

    <p class="text-xs text-gray-500 leading-relaxed mb-6">
        {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking the link we just emailed you? If you didn't receive it, we can send another.") }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="w-full text-white font-bold text-sm rounded-lg py-3" style="background:#171a2e;">
            {{ __('Resend verification email') }}
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
        @csrf
        <button type="submit" class="text-xs font-semibold text-gray-400">
            {{ __('Log out') }}
        </button>
    </form>

</x-guest-layout>