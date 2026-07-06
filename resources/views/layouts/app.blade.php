<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Planova — Your personal productivity workspace')">
    <title>@yield('title', 'Dashboard') — Planova</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- App styles & scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Force light mode for dashboard --}}
    <script>document.documentElement.classList.remove('dark');</script>

    @stack('head')
</head>
<body class="text-text-main antialiased" style="background-color:#F0FDFA; background-image: radial-gradient(circle at 15% 50%, rgba(45,212,191,0.10) 0%, transparent 50%), radial-gradient(circle at 85% 20%, rgba(249,115,22,0.07) 0%, transparent 45%); background-attachment: fixed;">

<div class="flex h-screen overflow-hidden w-full">

    {{-- Mobile overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    {{-- ── Sidebar ── --}}
    @include('components.sidebar')

    {{-- ── Main Area ── --}}
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        {{-- ── Topbar ── --}}
        @include('components.navbar')

        {{-- ── Flash Messages ── --}}
        @if(session('success') || session('error'))
        <div class="relative z-10 px-6 lg:px-8 pt-4 pointer-events-none">
            @if(session('success'))
                <div class="flex items-start gap-3 p-4 mb-3 rounded-2xl border border-green-200 bg-green-50/90 text-green-700 shadow-sm animate-fade-in-up pointer-events-auto" data-auto-dismiss>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-start gap-3 p-4 mb-3 rounded-2xl border border-red-200 bg-red-50/90 text-red-600 shadow-sm animate-fade-in-up pointer-events-auto" data-auto-dismiss>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span class="text-sm font-bold">{{ session('error') }}</span>
                </div>
            @endif
        </div>
        @endif

        {{-- ── Page Content ── --}}
        <div class="flex-1 overflow-y-auto px-4 lg:px-8 pb-8 pt-5">
            @yield('content')
        </div>

    </div>

</div>

<script>
    // Auto-dismiss flash messages
    document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.4s, transform 0.4s';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(() => el.remove(), 400);
        }, 3500);
    });
</script>

@stack('scripts')
</body>
</html>
