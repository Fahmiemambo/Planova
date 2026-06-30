<aside id="app-sidebar" class="w-64 flex-shrink-0 bg-surface-50 dark:bg-dark-surface border-r border-surface-500 dark:border-dark-border flex flex-col h-full transition-transform duration-300 absolute lg:relative z-50 -translate-x-full lg:translate-x-0">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-6 h-14 border-b border-surface-500 dark:border-dark-border flex-shrink-0">
        <div class="w-7 h-7 bg-primary rounded-md flex items-center justify-center text-white font-bold text-sm shadow-sm">P</div>
        <span class="font-bold text-base text-text-main dark:text-text-darkMain tracking-tight">Planova</span>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6">

        {{-- Main --}}
        <div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wider px-3 mb-2">Main</div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors p-interactive {{ request()->routeIs('dashboard') ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'text-text-secondary hover:bg-surface-200 hover:text-text-main dark:text-text-darkSecondary dark:hover:bg-dark-surface2 dark:hover:text-text-darkMain' }}">
                    <i class="bi bi-grid-1x2-fill text-lg"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('tasks.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors p-interactive {{ request()->routeIs('tasks.*') ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'text-text-secondary hover:bg-surface-200 hover:text-text-main dark:text-text-darkSecondary dark:hover:bg-dark-surface2 dark:hover:text-text-darkMain' }}">
                    <i class="bi bi-check2-square text-lg"></i>
                    <span>Tasks</span>
                </a>
                <a href="{{ route('notes.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors p-interactive {{ request()->routeIs('notes.*') ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'text-text-secondary hover:bg-surface-200 hover:text-text-main dark:text-text-darkSecondary dark:hover:bg-dark-surface2 dark:hover:text-text-darkMain' }}">
                    <i class="bi bi-journal-text text-lg"></i>
                    <span>Notes</span>
                </a>
            </div>
        </div>

        {{-- Finance --}}
        <div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wider px-3 mb-2">Keuangan</div>
            <div class="space-y-1">
                <a href="{{ route('finance.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors p-interactive {{ request()->routeIs('finance.*') ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'text-text-secondary hover:bg-surface-200 hover:text-text-main dark:text-text-darkSecondary dark:hover:bg-dark-surface2 dark:hover:text-text-darkMain' }}">
                    <i class="bi bi-wallet2 text-lg"></i>
                    <span>Finance</span>
                </a>
                <a href="{{ route('budget.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors p-interactive {{ request()->routeIs('budget.*') ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'text-text-secondary hover:bg-surface-200 hover:text-text-main dark:text-text-darkSecondary dark:hover:bg-dark-surface2 dark:hover:text-text-darkMain' }}">
                    <i class="bi bi-pie-chart-fill text-lg"></i>
                    <span>Budget</span>
                </a>
            </div>
        </div>

        {{-- Insights --}}
        <div>
            <div class="text-xs font-semibold text-text-muted dark:text-text-darkMuted uppercase tracking-wider px-3 mb-2">Insights</div>
            <div class="space-y-1">
                <a href="{{ route('analytics.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors p-interactive {{ request()->routeIs('analytics.*') ? 'bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light' : 'text-text-secondary hover:bg-surface-200 hover:text-text-main dark:text-text-darkSecondary dark:hover:bg-dark-surface2 dark:hover:text-text-darkMain' }}">
                    <i class="bi bi-bar-chart-line-fill text-lg"></i>
                    <span>Analytics</span>
                </a>
            </div>
        </div>

    </nav>

    {{-- Footer / User --}}
    <div class="p-4 border-t border-surface-500 dark:border-dark-border flex-shrink-0">
        @auth
        <div class="relative group">
            <button class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-surface-200 dark:hover:bg-dark-surface2 transition-colors text-left focus:outline-none p-interactive">
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold shadow-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-text-main dark:text-text-darkMain truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-text-muted dark:text-text-darkMuted truncate">Personal</div>
                </div>
                <i class="bi bi-chevron-up text-text-muted text-xs"></i>
            </button>
            
            {{-- Dropdown (CSS Hover based for simplicity or JS based. Let's use group-hover for pure CSS) --}}
            <div class="absolute bottom-full left-0 w-full mb-2 bg-surface-200 dark:bg-dark-surface border border-surface-500 dark:border-dark-border rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 py-1">
                <a href="{{ route('profile.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-text-main dark:text-text-darkMain hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors">
                    <i class="bi bi-person"></i> Profile
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-text-main dark:text-text-darkMain hover:bg-surface-100 dark:hover:bg-dark-surface2 transition-colors">
                    <i class="bi bi-gear"></i> Settings
                </a>
                <div class="h-px bg-surface-500 dark:bg-dark-border my-1"></div>
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

</aside>

<script>
    // Simple mobile sidebar toggle script since we removed jQuery/Bootstrap JS
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggles = document.querySelectorAll('.sidebar-toggle-btn');
        
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        toggles.forEach(btn => btn.addEventListener('click', toggleSidebar));
        overlay?.addEventListener('click', toggleSidebar);
    });
</script>
