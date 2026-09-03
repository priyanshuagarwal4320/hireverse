<aside class="w-60 h-full overflow-y-auto bg-white border-r border-gray-200 flex-shrink-0">
    <div class="flex items-center gap-2 px-4 py-5 border-b border-gray-200">
        <svg width="26" height="26" viewBox="0 0 100 100">
            <rect width="100" height="100" rx="24" fill="#171a2e" />
            <rect x="27" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
            <rect x="62" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
            <path d="M50 36 L61 50 L50 64 L39 50 Z" fill="#fff" />
        </svg>
        <span class="font-extrabold text-base">Hire<span class="text-violet-600">Verse</span></span>
    </div>

    <nav class="p-4 space-y-1">
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold bg-violet-50 text-violet-700">Dashboard</a>
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pt-4 pb-1">Platform</p>
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Companies</a>
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Candidates</a>
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Jobs</a>
        @elseif(auth()->user()->role === 'company')
            <a href="{{ route('company.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold bg-violet-50 text-violet-700">Dashboard</a>
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pt-4 pb-1">Recruitment</p>
            <a href="{{ route('company.profile.edit') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Company
                profile</a>
            <a href="{{ route('company.jobs.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">My
                jobs</a>
        @else
            <a href="{{ route('candidate.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold bg-violet-50 text-violet-700">Browse
                jobs</a>
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pt-4 pb-1">My account</p>
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">My
                profile</a>
            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">My
                applications</a>
            <a href="{{ route('candidate.interviews') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Interviews</a>
            <a href="{{ route('candidate.results') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Results</a>
        @endif
    </nav>

    <div class="mt-6 mx-4 p-3 rounded-xl bg-gray-50 flex items-center gap-3">
        <div
            class="w-8 h-8 rounded-lg bg-violet-600 text-white flex items-center justify-center text-xs font-extrabold flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div>
            <p class="text-xs font-bold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400">{{ ucfirst(auth()->user()->role) }}</p>
        </div>
    </div>
</aside>
