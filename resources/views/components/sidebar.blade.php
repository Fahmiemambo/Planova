<aside id="app-sidebar"
    class="w-64 flex-shrink-0 flex flex-col h-full transition-transform duration-300 absolute lg:relative z-50 -translate-x-full lg:translate-x-0"
    style="background: rgba(240,253,250,0.95); backdrop-filter: blur(12px); border-right: 1.5px solid rgba(255,255,255,0.7);">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-5 h-16 border-b border-white/60 flex-shrink-0">
        <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center text-white shadow-clay-sm transition-transform hover:scale-105 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <span class="font-extrabold text-lg text-primary-dark tracking-tight">Plano<span class="text-primary">va</span></span>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-6">

        {{-- MAIN --}}
        <div>
            <div class="text-[10px] font-extrabold text-primary/50 uppercase tracking-widest px-3 mb-2">Main</div>
            <div class="space-y-1">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all
                    {{ request()->routeIs('dashboard')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-primary-dark hover:bg-white/80 hover:text-primary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Dashboard</span>
                </a>

                {{-- Tasks --}}
                <a href="{{ route('tasks.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all
                    {{ request()->routeIs('tasks.*')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-primary-dark hover:bg-white/80 hover:text-primary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    <span>Tasks</span>
                </a>

                {{-- Documents --}}
                <a href="{{ route('documents.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all
                    {{ request()->routeIs('documents.*')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-primary-dark hover:bg-white/80 hover:text-primary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    <span>Documents</span>
                </a>

            </div>
        </div>

        {{-- KEUANGAN --}}
        <div>
            <div class="text-[10px] font-extrabold text-primary/50 uppercase tracking-widest px-3 mb-2">Keuangan</div>
            <div class="space-y-1">

                {{-- Finance --}}
                <a href="{{ route('finance.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all
                    {{ request()->routeIs('finance.*')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-primary-dark hover:bg-white/80 hover:text-primary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    <span>Finance</span>
                </a>

                {{-- Budget --}}
                <a href="{{ route('budget.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all
                    {{ request()->routeIs('budget.*')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-primary-dark hover:bg-white/80 hover:text-primary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    <span>Budget</span>
                </a>

            </div>
        </div>

        {{-- INSIGHTS --}}
        <div>
            <div class="text-[10px] font-extrabold text-primary/50 uppercase tracking-widest px-3 mb-2">Insights</div>
            <div class="space-y-1">

                {{-- Analytics --}}
                <a href="{{ route('analytics.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all
                    {{ request()->routeIs('analytics.*')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-primary-dark hover:bg-white/80 hover:text-primary' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span>Analytics</span>
                </a>

            </div>
        </div>

    </nav>

    {{-- User Profile Area --}}
    <div class="p-3 border-t border-white/60 flex-shrink-0">
        <div class="flex items-center justify-between p-2.5 bg-white/60 rounded-xl hover:bg-white transition-colors cursor-pointer">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-extrabold text-sm flex-shrink-0 shadow-clay-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-extrabold text-primary-dark truncate">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="text-xs text-primary/60 truncate font-bold">Personal Workspace</div>
                </div>
            </div>
            <div class="flex items-center gap-1 flex-shrink-0">
                <a href="{{ route('profile.index') }}"
                    class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-primary/10 text-primary/60 hover:text-primary transition-colors"
                    title="Settings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                        class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-red-50 text-primary/60 hover:text-red-500 transition-colors"
                        title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
