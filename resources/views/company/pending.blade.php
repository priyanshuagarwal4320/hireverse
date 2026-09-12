@extends('layouts.dashboard')

@section('page-title', 'Account pending')

@section('content')

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-10 max-w-xl mx-auto text-center mt-10">
        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fas fa-clock"></i>
        </div>
        <h1 class="text-lg font-extrabold mb-2">Your account is pending verification</h1>
        <p class="text-sm text-gray-500 mb-6">
            Our team is reviewing your company details. Once verified, you'll get full access to post jobs and manage applicants. This usually takes 1-2 business days.
        </p>
                <div class="flex items-center justify-center gap-3">
            <a href="{{ route('company.profile.edit') }}" class="text-xs font-bold px-6 py-3 rounded-lg text-white" style="background:#171a2e;">
                Complete your profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-semibold text-gray-500">
                    Logout
                </button>
            </form>
        </div>
    </div>

@endsection