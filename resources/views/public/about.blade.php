<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6d4aff">
    <title>About — Planova</title>
    <meta name="description" content="Tentang Planova, platform produktivitas modern dengan pengalaman premium.">
    <meta property="og:title" content="About — Planova">
    <meta property="og:description" content="Tentang Planova, platform produktivitas modern dengan pengalaman premium.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-surface-100 text-text-main dark:bg-dark-bg dark:text-text-darkMain theme-transition overflow-x-hidden">
    @include('components.public-navbar')
    <main class="mx-auto max-w-6xl px-6 py-8 lg:px-8">

    <section class="grid gap-8 lg:grid-cols-[1fr_0.8fr]">
        <div class="space-y-6 rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
            <div class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary">About</div>
            <h1 class="text-4xl font-bold leading-tight">Planova adalah workspace produktivitas yang terasa seperti ide yang hidup.</h1>
            <p class="text-lg leading-8 text-text-secondary dark:text-text-darkSecondary">Kami menggabungkan task management, notes, finance, dan dashboard insight menjadi satu ekosistem yang modern, cepat, dan estetis. Semua interaksi dirancang agar terasa realtime dan premium.</p>
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-surface-500 bg-surface-100 p-4 dark:border-dark-border dark:bg-dark-bg/70">
                    <div class="text-2xl font-semibold text-text-main dark:text-text-darkMain">Realtime</div>
                    <div class="text-sm text-text-muted dark:text-text-darkMuted">Interaksi yang mulus</div>
                </div>
                <div class="rounded-2xl border border-surface-500 bg-surface-100 p-4 dark:border-dark-border dark:bg-dark-bg/70">
                    <div class="text-2xl font-semibold text-text-main dark:text-text-darkMain">Premium</div>
                    <div class="text-sm text-text-muted dark:text-text-darkMuted">Visual dan animasi halus</div>
                </div>
                <div class="rounded-2xl border border-surface-500 bg-surface-100 p-4 dark:border-dark-border dark:bg-dark-bg/70">
                    <div class="text-2xl font-semibold text-text-main dark:text-text-darkMain">Flexible</div>
                    <div class="text-sm text-text-muted dark:text-text-darkMuted">Task, notes, finance</div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
            <h2 class="text-2xl font-semibold">Apa yang bisa Anda lakukan?</h2>
            <ul class="mt-5 space-y-3 text-text-secondary dark:text-text-darkSecondary">
                <li class="flex gap-3"><i class="bi bi-check-circle-fill text-primary"></i> Mengelola task dengan pengalaman seperti Notion</li>
                <li class="flex gap-3"><i class="bi bi-check-circle-fill text-primary"></i> Menulis notes dengan blok editor dan editor yang rapi</li>
                <li class="flex gap-3"><i class="bi bi-check-circle-fill text-primary"></i> Memantau keuangan dan budget secara visual</li>
                <li class="flex gap-3"><i class="bi bi-check-circle-fill text-primary"></i> Menikmati tema gelap dan terang yang konsisten</li>
            </ul>
        </div>
    </section>
</div>
</body>
</html>
