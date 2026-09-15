<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-7">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen"
            class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-gray-100">
            <i class="fas fa-bars text-sm"></i>
        </button>
        <div>
            <p class="text-sm font-bold">@yield('page-title', 'Dashboard')</p>
            <p class="text-xs text-gray-400">Home / @yield('page-title', 'Dashboard')</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
                <i class="fas fa-bell text-sm"></i>
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-50"
                style="display:none;">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <p class="text-xs font-bold">Notifications</p>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <form method="POST" action="{{ route('notifications.read-all') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-violet-600">Mark all read</button>
                        </form>
                    @endif
                </div>
                <div class="max-h-80 overflow-y-auto">
                    @forelse(auth()->user()->notifications()->latest()->take(8)->get() as $notification)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 border-b border-gray-50 hover:bg-gray-50 flex items-start gap-2 {{ $notification->read_at ? '' : 'bg-violet-50/40' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full mt-1.5 flex-shrink-0 {{ $notification->read_at ? 'bg-transparent' : 'bg-violet-600' }}"></span>
                                <span class="text-xs text-gray-600">{{ $notification->data['message'] }}</span>
                            </button>
                        </form>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-6">No notifications yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
            <i class="fas fa-envelope text-sm"></i>
        </div> --}}
        @php
            $topbarAvatar = null;
            if (auth()->user()->role === 'company' && auth()->user()->company?->logo) {
                $topbarAvatar = auth()->user()->company->logo;
            } elseif (auth()->user()->role === 'candidate' && auth()->user()->candidate?->profile_photo) {
                $topbarAvatar = auth()->user()->candidate->profile_photo;
            }
        @endphp
        @if ($topbarAvatar)
            <img src="{{ asset('storage/' . $topbarAvatar) }}" class="w-9 h-9 rounded-lg object-cover">
        @else
            <div
                class="w-9 h-9 rounded-lg bg-violet-600 text-white flex items-center justify-center text-xs font-extrabold">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-semibold text-gray-500 hover:text-gray-800 ml-2">Logout</button>
        </form>
    </div>
</header>
