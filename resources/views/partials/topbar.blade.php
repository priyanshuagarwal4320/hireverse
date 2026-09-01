<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-7">
    <div>
        <p class="text-sm font-bold">@yield('page-title', 'Dashboard')</p>
        <p class="text-xs text-gray-400">Home / @yield('page-title', 'Dashboard')</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
            <i class="fas fa-bell text-sm"></i>
        </div>
        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
            <i class="fas fa-envelope text-sm"></i>
        </div>
        <div class="w-9 h-9 rounded-lg bg-violet-600 text-white flex items-center justify-center text-xs font-extrabold">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-semibold text-gray-500 hover:text-gray-800 ml-2">Logout</button>
        </form>
    </div>
</header>