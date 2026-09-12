<aside class="h-full overflow-y-auto bg-white border-r border-gray-200 flex-shrink-0 transition-all duration-200"
    :class="sidebarOpen ? 'w-60' : 'w-20'">
    <div class="flex items-center gap-2 px-4 py-5 border-b border-gray-200" :class="!sidebarOpen && 'justify-center px-2'">
        <svg width="26" height="26" viewBox="0 0 100 100" class="flex-shrink-0">
            <rect width="100" height="100" rx="24" fill="#171a2e" />
            <rect x="27" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
            <rect x="62" y="24" width="11" height="52" rx="5.5" fill="#6c5ce7" />
            <path d="M50 36 L61 50 L50 64 L39 50 Z" fill="#fff" />
        </svg>
        <span class="font-extrabold text-base whitespace-nowrap" x-show="sidebarOpen">Hire<span class="text-violet-600">Verse</span></span>
    </div>

    <nav class="p-4 space-y-1">
        @if (auth()->user()->role === 'admin')
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pb-1" x-show="sidebarOpen">Main</p>
            <a href="{{ route('admin.dashboard') }}" title="Dashboard"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-gauge-high w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
            </a>
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pt-4 pb-1" x-show="sidebarOpen">Platform</p>
            <a href="{{ route('admin.companies.index') }}" title="Companies"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.companies.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-building w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Companies</span>
            </a>
            <a href="{{ route('admin.candidates.index') }}" title="Candidates"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.candidates.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-users w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Candidates</span>
            </a>
            <a href="{{ route('admin.jobs.index') }}" title="Jobs"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.jobs.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-briefcase w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Jobs</span>
            </a>
            <a href="{{ route('admin.applications.index') }}" title="Applications"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.applications.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-file-lines w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Applications</span>
            </a>
            <a href="{{ route('admin.interviews.index') }}" title="Interviews"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.interviews.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-calendar-check w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Interviews</span>
            </a>
            <a href="{{ route('admin.results.index') }}" title="Results"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.results.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-chart-simple w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Results</span>
            </a>
        @elseif(auth()->user()->role === 'company')
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pb-1" x-show="sidebarOpen">Main</p>
            <a href="{{ route('company.dashboard') }}" title="Dashboard"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('company.dashboard') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-gauge-high w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
            </a>
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pt-4 pb-1" x-show="sidebarOpen">Recruitment</p>
            <a href="{{ route('company.profile.edit') }}" title="Company profile"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('company.profile.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-building w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Company profile</span>
            </a>
            <a href="{{ route('company.jobs.index') }}" title="My jobs"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('company.jobs.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-briefcase w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">My jobs</span>
            </a>
            <a href="{{ route('company.applications') }}" title="Applications"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('company.applications') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-file-lines w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Applications</span>
            </a>
            <a href="{{ route('company.interviews') }}" title="Interviews"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('company.interviews') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-calendar-check w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Interviews</span>
            </a>
        @else
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pb-1" x-show="sidebarOpen">Main</p>
            <a href="{{ route('candidate.dashboard') }}" title="Browse jobs"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate.dashboard') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-magnifying-glass w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Browse jobs</span>
            </a>
            <a href="{{ route('candidate.saved-jobs') }}" title="Saved jobs"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate.saved-jobs') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-bookmark w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Saved jobs</span>
            </a>
            <p class="text-xs font-bold text-gray-400 uppercase px-3 pt-4 pb-1" x-show="sidebarOpen">My account</p>
            <a href="{{ route('candidate.profile.edit') }}" title="My profile"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate.profile.*') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-user w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">My profile</span>
            </a>
            <a href="{{ route('candidate.applications') }}" title="My applications"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate.applications') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-file-lines w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">My applications</span>
            </a>
            <a href="{{ route('candidate.interviews') }}" title="Interviews"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate.interviews') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-calendar-check w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Interviews</span>
            </a>
            <a href="{{ route('candidate.results') }}" title="Results"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate.results') ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-chart-simple w-4 text-center flex-shrink-0"></i> <span x-show="sidebarOpen" class="whitespace-nowrap">Results</span>
            </a>
        @endif
    </nav>

    <div class="mt-6 mx-4 p-3 rounded-xl bg-gray-50 flex items-center gap-3" :class="!sidebarOpen && 'justify-center mx-2 px-2'">
        @php
            $avatarImage = null;
            if (auth()->user()->role === 'company' && auth()->user()->company?->logo) {
                $avatarImage = auth()->user()->company->logo;
            } elseif (auth()->user()->role === 'candidate' && auth()->user()->candidate?->profile_photo) {
                $avatarImage = auth()->user()->candidate->profile_photo;
            }
        @endphp
        @if ($avatarImage)
            <img src="{{ asset('storage/' . $avatarImage) }}" class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
        @else
            <div
                class="w-8 h-8 rounded-lg bg-violet-600 text-white flex items-center justify-center text-xs font-extrabold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        @endif
        <div x-show="sidebarOpen">
            <p class="text-xs font-bold whitespace-nowrap">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 whitespace-nowrap">{{ ucfirst(auth()->user()->role) }}</p>
        </div>
    </div>
</aside>