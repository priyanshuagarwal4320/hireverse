<x-guest-layout>

    <h1 class="text-xl font-extrabold mb-1">Set a new password</h1>
    <div class="w-12 h-1 rounded-full mb-6" style="background:#6c5ce7;"></div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <div class="relative mt-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-envelope"></i>
                </span>
                <x-text-input id="email" class="block w-full pl-9" type="email" name="email"
                    :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New password')" />
            <div class="relative mt-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password" class="block w-full pl-9" type="password" name="password"
                    required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
            <div class="relative mt-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password_confirmation" class="block w-full pl-9" type="password"
                    name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full text-white font-bold text-sm rounded-lg py-3 mt-2" style="background:#171a2e;">
            {{ __('Reset password') }}
        </button>

    </form>

</x-guest-layout>