<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Planova — Your personal productivity workspace')">
    <title>@yield('title', 'Planova') — Planova</title>

    {{-- Bootstrap Icons (still useful for quick icons) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Vite Scripts and Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Check theme on page load to prevent FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-surface-100 text-text-main dark:bg-dark-bg dark:text-text-darkMain antialiased">

<div class="flex h-screen overflow-hidden w-full">

    {{-- Mobile overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    {{-- ── Sidebar ── --}}
    @include('components.sidebar')

    {{-- ── Main Area ── --}}
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        {{-- ── Topbar ── --}}
        @include('components.navbar')

        {{-- ── Flash Messages ── --}}
        <div id="flash-container" class="relative z-10 px-8 mt-4 pointer-events-none">
            @if(session('success'))
                <div class="alert-p bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 flex items-start gap-3 p-4 rounded-lg shadow-sm animate-fade-in-up mb-4 pointer-events-auto" data-auto-dismiss>
                    <i class="bi bi-check-circle-fill mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-p bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 flex items-start gap-3 p-4 rounded-lg shadow-sm animate-fade-in-up mb-4 pointer-events-auto" data-auto-dismiss>
                    <i class="bi bi-exclamation-circle-fill mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        {{-- ── Page Content ── --}}
        <div class="flex-1 overflow-y-auto px-4 lg:px-8 pb-8 pt-4">
            @yield('content')
        </div>

    </div>{{-- /.main-area --}}

</div>{{-- /.flex wrapper --}}

<script>
    // Custom JS flash autohide
    document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            el.style.transition = 'opacity 0.4s, transform 0.4s';
            setTimeout(() => el.remove(), 400);
        }, 3000);
    });
</script>
@stack('scripts')

</body>
</html>
