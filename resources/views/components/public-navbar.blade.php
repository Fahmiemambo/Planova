<header class="relative z-20 mx-auto w-full max-w-7xl px-6 py-6 lg:px-8">
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary text-lg font-bold text-white shadow-lg shadow-primary/20">P</div>
            <div>
                <div class="text-lg font-semibold tracking-tight">Planova</div>
                <div class="text-sm text-text-muted dark:text-text-darkMuted">Productivity OS</div>
            </div>
        </a>

        <div class="flex items-center gap-3">
            <button type="button" class="public-menu-toggle lg:hidden inline-flex items-center justify-center rounded-lg border border-surface-500 bg-surface-100 p-2 text-text-main dark:border-dark-border dark:bg-dark-surface dark:text-text-darkMain transition-colors duration-200 hover:bg-surface-200 dark:hover:bg-dark-surface2" aria-controls="public-mobile-menu" aria-expanded="false" aria-label="Toggle navigation menu">
                <span class="sr-only">Toggle navigation</span>
                <i class="bi bi-list text-xl"></i>
            </button>

            <nav class="hidden items-center gap-3 text-sm font-medium lg:flex">
                <a href="{{ route('home') }}" class="nav-planova-link px-3 py-2 rounded-md transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary' : 'text-text-secondary hover:text-primary' }} dark:{{ request()->routeIs('home') ? 'text-primary' : 'text-text-darkSecondary dark:hover:text-primary-light' }}">Home</a>
                <a href="{{ route('about') }}" class="nav-planova-link px-3 py-2 rounded-md transition-colors duration-200 {{ request()->routeIs('about') ? 'text-primary' : 'text-text-secondary hover:text-primary' }} dark:{{ request()->routeIs('about') ? 'text-primary' : 'text-text-darkSecondary dark:hover:text-primary-light' }}">About</a>
                <a href="{{ route('developers') }}" class="nav-planova-link px-3 py-2 rounded-md transition-colors duration-200 {{ request()->routeIs('developers') ? 'text-primary' : 'text-text-secondary hover:text-primary' }} dark:{{ request()->routeIs('developers') ? 'text-primary' : 'text-text-darkSecondary dark:hover:text-primary-light' }}">Developers</a>
                <a href="{{ route('feedback') }}" class="nav-planova-link px-3 py-2 rounded-md transition-colors duration-200 {{ request()->routeIs('feedback') ? 'text-primary' : 'text-text-secondary hover:text-primary' }} dark:{{ request()->routeIs('feedback') ? 'text-primary' : 'text-text-darkSecondary dark:hover:text-primary-light' }}">Feedback</a>
                <a href="{{ route('login') }}" class="btn-planova btn-primary-p ml-2">Masuk</a>
            </nav>
        </div>
    </div>

    <div id="public-mobile-menu" class="lg:hidden hidden mt-4 rounded-3xl border border-surface-300 bg-white/95 p-4 shadow-xl backdrop-blur dark:border-dark-border dark:bg-dark-surface/95">
        <div class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-text-main hover:bg-surface-100 dark:text-text-darkMain dark:hover:bg-dark-surface2">Home</a>
            <a href="{{ route('about') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-text-main hover:bg-surface-100 dark:text-text-darkMain dark:hover:bg-dark-surface2">About</a>
            <a href="{{ route('developers') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-text-main hover:bg-surface-100 dark:text-text-darkMain dark:hover:bg-dark-surface2">Developers</a>
            <a href="{{ route('feedback') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-text-main hover:bg-surface-100 dark:text-text-darkMain dark:hover:bg-dark-surface2">Feedback</a>
            <a href="{{ route('login') }}" class="btn-planova btn-primary-p w-full text-center">Masuk</a>
            <button id="theme-toggle-mobile" type="button" class="inline-flex items-center justify-center rounded-lg border border-surface-300 bg-surface-100 px-4 py-3 text-sm font-medium text-text-main transition-colors duration-200 hover:bg-surface-200 dark:border-dark-border dark:bg-dark-surface dark:text-text-darkMain dark:hover:bg-dark-surface2" aria-label="Toggle light/dark mode">
                <i id="theme-toggle-icon-mobile" class="bi bi-moon"></i>
            </button>
        </div>
    </div>
</header>
