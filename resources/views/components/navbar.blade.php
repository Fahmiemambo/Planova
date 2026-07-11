<header class="h-16 flex items-center px-4 lg:px-8 gap-3 flex-shrink-0 z-30"
    style="background: rgba(240,253,250,0.90); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1.5px solid rgba(255,255,255,0.7);">

    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 flex-shrink-0 group">
        <div class="w-9 h-9 rounded-xl overflow-hidden">
            <img src="/images/planova-logo.png" alt="Planova" class="w-full h-full object-contain">
        </div>
        <span class="font-bold text-primary hidden sm:inline">Planova</span>
    </a>

    {{-- Mobile Sidebar toggle --}}
    <button class="sidebar-toggle-btn lg:hidden btn-planova btn-secondary-p !px-2.5 !py-2 flex-shrink-0" aria-label="Toggle sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    {{-- Page title / breadcrumb --}}
    <nav class="flex-1 flex items-center gap-2 min-w-0" aria-label="breadcrumb">
        @isset($breadcrumbs)
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->last)
                    <div class="flex items-center gap-1.5">
                        <a href="{{ $crumb['url'] }}" class="text-sm font-bold text-primary/55 hover:text-primary transition-colors truncate max-w-[150px]">
                            {{ $crumb['label'] }}
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary/30 flex-shrink-0"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                @else
                    <span class="text-xl font-extrabold text-primary-dark truncate">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        @else
            <span class="text-xl font-extrabold text-primary-dark truncate">@yield('page_title', 'Dashboard')</span>
        @endisset
    </nav>

    {{-- Search bar --}}
    <div class="hidden md:flex items-center gap-2 bg-white/70 border border-white/90 rounded-xl px-3 py-2 w-56 shadow-sm transition-all focus-within:w-64 focus-within:shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary/50 flex-shrink-0"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Cari..." class="bg-transparent border-none outline-none text-sm font-bold placeholder-primary/35 text-primary-dark w-full">
    </div>

    {{-- Quick actions --}}
    <div class="flex items-center gap-2 flex-shrink-0">
        <a href="{{ route('tasks.create') }}" class="btn-planova btn-primary-p btn-sm-p hidden sm:inline-flex gap-1.5" title="Task Baru">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Task
        </a>

        {{-- User avatar dropdown --}}
        @auth
        <div class="relative group">
            <button class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-extrabold text-sm shadow-clay-sm hover:scale-105 transition-transform focus:outline-none cursor-pointer select-none"
                aria-label="User menu">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </button>
            <div class="absolute right-0 top-full mt-2 w-56 bg-white/95 backdrop-blur border border-primary/10 rounded-2xl shadow-clay opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden origin-top-right scale-95 group-hover:scale-100">
                <div class="px-4 py-3.5 bg-primary/5 border-b border-primary/10">
                    <div class="text-sm font-extrabold text-primary-dark truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs font-bold text-primary/55 truncate mt-0.5">{{ auth()->user()->email }}</div>
                </div>
                <div class="p-1.5">
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-primary-dark hover:bg-primary/8 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary/60"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Pengaturan
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition-colors text-left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </div>

</header>

<script>
    // Mobile sidebar toggle
    const sidebarToggle = document.querySelector('.sidebar-toggle-btn');
    const sidebar = document.getElementById('app-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', isOpen);
            overlay?.classList.toggle('hidden', isOpen);
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    }
</script>
