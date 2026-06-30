<header class="h-14 bg-surface-200 dark:bg-dark-surface border-b border-surface-500 dark:border-dark-border flex items-center px-4 lg:px-8 gap-4 flex-shrink-0 z-30">

    {{-- Mobile Sidebar toggle button --}}
    <button class="sidebar-toggle-btn lg:hidden p-2 rounded-md text-text-secondary dark:text-text-darkSecondary hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors">
        <i class="bi bi-list text-xl"></i>
    </button>

    {{-- Breadcrumb --}}
    <nav class="flex-1 flex items-center gap-1 min-w-0" aria-label="breadcrumb">
        @isset($breadcrumbs)
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->last)
                    <div class="flex items-center gap-1">
                        <a href="{{ $crumb['url'] }}" class="text-sm font-medium text-text-muted dark:text-text-darkMuted hover:text-text-main dark:hover:text-text-darkMain truncate max-w-[150px]">
                            {{ $crumb['label'] }}
                        </a>
                        <span class="text-surface-500 dark:text-dark-border"><i class="bi bi-chevron-right text-[10px]"></i></span>
                    </div>
                @else
                    <span class="text-sm font-semibold text-text-main dark:text-text-darkMain truncate">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        @else
            <span class="text-sm font-semibold text-text-main dark:text-text-darkMain truncate">@yield('page_title', 'Dashboard')</span>
        @endisset
    </nav>

    {{-- Search --}}
    <div class="hidden md:flex items-center gap-2 bg-surface-100 dark:bg-dark-bg border border-surface-500 dark:border-dark-border rounded-lg px-3 py-1.5 w-64 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 dark:focus-within:border-primary dark:focus-within:ring-primary/40 transition-all">
        <i class="bi bi-search text-text-muted dark:text-text-darkMuted text-sm"></i>
        <input type="text" placeholder="Search…" class="bg-transparent border-none outline-none text-sm w-full text-text-main dark:text-text-darkMain placeholder-text-muted dark:placeholder-text-darkMuted">
    </div>

    {{-- Right Actions --}}
    <div class="flex items-center gap-3 flex-shrink-0">
        {{-- Dark Mode Toggle --}}
        <button id="theme-toggle" class="p-2 rounded-full text-text-secondary dark:text-text-darkSecondary hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors focus:outline-none">
            <i id="theme-toggle-icon" class="bi bi-moon text-lg block"></i>
        </button>

        @auth
        <div class="relative group hidden lg:block">
            <button class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold hover:opacity-90 transition-opacity focus:outline-none">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </button>
            <div class="absolute right-0 top-full mt-2 w-48 bg-surface-200 dark:bg-dark-surface border border-surface-500 dark:border-dark-border rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 py-1">
                <div class="px-4 py-2 border-b border-surface-500 dark:border-dark-border mb-1">
                    <div class="text-sm font-semibold text-text-main dark:text-text-darkMain truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-text-muted dark:text-text-darkMuted truncate">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-text-main dark:text-text-darkMain hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors">
                    <i class="bi bi-person"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors text-left">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>

</header>
