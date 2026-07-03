<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6d4aff">
    <title>Developers — Planova</title>
    <meta name="description" content="Tim developer Planova membangun pengalaman produktivitas modern.">
    <meta property="og:title" content="Developers — Planova">
    <meta property="og:description" content="Tim developer Planova membangun pengalaman produktivitas modern.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-surface-100 text-text-main dark:bg-dark-bg dark:text-text-darkMain theme-transition overflow-x-hidden">
    @include('components.public-navbar')
    <main class="mx-auto max-w-6xl px-6 py-8 lg:px-8">

    <section class="space-y-10">
        <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
            <h1 class="text-4xl font-black tracking-tight text-text-main dark:text-white">Tim Developer Planova</h1>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-text-secondary dark:text-text-darkSecondary">
                Ini adalah orang-orang yang merancang, membangun, dan mempertahankan pengalaman Planova. Bukan sekadar teknologi—mereka yang bekerja untuk membuat task manager terasa mudah, personal, dan efisien.
            </p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-primary text-2xl font-semibold text-white">A</div>
                <h2 class="text-2xl font-semibold">Alya Mahendra</h2>
                <p class="mt-2 text-sm uppercase text-text-muted dark:text-text-darkMuted tracking-[0.18em]">Lead Product</p>
                <p class="mt-4 text-text-secondary dark:text-text-darkSecondary">Memimpin visi produk dan memastikan pengalaman Planova tetap sederhana, cepat, dan intuitif.</p>
            </div>
            <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500 text-2xl font-semibold text-white">B</div>
                <h2 class="text-2xl font-semibold">Bayu Pratama</h2>
                <p class="mt-2 text-sm uppercase text-text-muted dark:text-text-darkMuted tracking-[0.18em]">Senior Backend</p>
                <p class="mt-4 text-text-secondary dark:text-text-darkSecondary">Mengelola arsitektur server, data, dan autentikasi supaya semua berjalan aman dan stabil.</p>
            </div>
            <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500 text-2xl font-semibold text-white">C</div>
                <h2 class="text-2xl font-semibold">Citra Dewi</h2>
                <p class="mt-2 text-sm uppercase text-text-muted dark:text-text-darkMuted tracking-[0.18em]">Frontend Engineer</p>
                <p class="mt-4 text-text-secondary dark:text-text-darkSecondary">Menciptakan antarmuka yang responsif dan interaktif, sehingga Planova terasa lancar di setiap perangkat.</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500 text-2xl font-semibold text-white">D</div>
                <h2 class="text-2xl font-semibold">Deni Rahman</h2>
                <p class="mt-2 text-sm uppercase text-text-muted dark:text-text-darkMuted tracking-[0.18em]">DevOps & Infrastruktur</p>
                <p class="mt-4 text-text-secondary dark:text-text-darkSecondary">Menjaga lingkungan deployment yang stabil dan memastikan respon sistem tetap cepat.</p>
            </div>
            <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-fuchsia-500 text-2xl font-semibold text-white">E</div>
                <h2 class="text-2xl font-semibold">Erika Sari</h2>
                <p class="mt-2 text-sm uppercase text-text-muted dark:text-text-darkMuted tracking-[0.18em]">UX Researcher</p>
                <p class="mt-4 text-text-secondary dark:text-text-darkSecondary">Mencari masukan pengguna agar setiap fitur Planova terasa lebih mudah digunakan.</p>
            </div>
            <div class="rounded-3xl border border-surface-500 bg-surface-200/80 p-8 shadow-lg dark:border-dark-border dark:bg-dark-surface/80">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-500 text-2xl font-semibold text-white">F</div>
                <h2 class="text-2xl font-semibold">Farhan Yusuf</h2>
                <p class="mt-2 text-sm uppercase text-text-muted dark:text-text-darkMuted tracking-[0.18em]">Mobile & Integrasi</p>
                <p class="mt-4 text-text-secondary dark:text-text-darkSecondary">Membangun koneksi dan integrasi sehingga Planova bisa terhubung dengan alur kerja Anda.</p>
            </div>
        </div>
    </section>
</div>
</body>
</html>
