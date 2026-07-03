<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6d4aff">
    <title>Feedback — Planova</title>
    <meta name="description" content="Kirimkan feedback untuk Planova.">
    <meta property="og:title" content="Feedback — Planova">
    <meta property="og:description" content="Kirimkan feedback untuk Planova.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-surface-100 text-text-main dark:bg-dark-bg dark:text-text-darkMain theme-transition overflow-x-hidden">
    @include('components.public-navbar')
    <main class="mx-auto max-w-4xl px-6 py-12 lg:px-8">

    <section class="rounded-[2rem] border border-surface-500 bg-surface-200/80 p-8 shadow-2xl dark:border-dark-border dark:bg-dark-surface/90">
        <div class="grid gap-8 lg:grid-cols-[1fr_0.9fr]">
            <div class="space-y-6">
                <div class="rounded-3xl bg-white/90 p-6 shadow-sm dark:bg-dark-bg/90">
                    <h2 class="text-2xl font-semibold text-text-main dark:text-white">Feedback cepat</h2>
                    <p class="mt-3 text-text-secondary dark:text-text-darkSecondary">Tuliskan pengalamanmu, ide fitur, atau masalah yang kamu temui.</p>
                </div>
                <div class="rounded-3xl border border-surface-500 bg-surface-100 p-6 dark:border-dark-border dark:bg-dark-surface2/80">
                    <p class="text-sm text-text-muted dark:text-text-darkMuted">Saranmu akan langsung dikumpulkan dan ditinjau oleh tim Planova.</p>
                </div>
            </div>

            <form action="/feedback" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="form-label-p">Nama</label>
                    <input id="name" name="name" class="form-control-p" type="text" placeholder="Nama kamu" />
                </div>
                <div>
                    <label for="email" class="form-label-p">Email</label>
                    <input id="email" name="email" class="form-control-p" type="email" placeholder="Email aktif" />
                </div>
                <div>
                    <label for="feedback" class="form-label-p">Feedback</label>
                    <textarea id="feedback" name="feedback" rows="6" class="form-control-p" placeholder="Tulis feedback kamu di sini..."></textarea>
                </div>
                <button type="submit" class="btn-planova btn-primary-p w-full px-5 py-3 text-base">Kirim Feedback</button>
            </form>
        </div>
    </section>
</div>
</body>
</html>
