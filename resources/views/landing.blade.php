<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0D9488">
    <title>Planova — Workspace Produktivitas All-in-One</title>
    <meta name="description" content="Planova menggabungkan task manager, pencatatan keuangan, budget, dokumen, dan analitik dalam satu workspace yang elegan dan intuitif.">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="/images/planova-logo.png">
    <link rel="shortcut icon" href="/images/planova-logo.png">
    <link rel="apple-touch-icon" href="/images/planova-logo.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body class="min-h-full font-sans text-text-main antialiased overflow-x-hidden">

{{-- ═══════════════════════════════════════════════
     NAVIGATION
     ═══════════════════════════════════════════════ --}}
<nav id="landing-nav" class="landing-nav fixed top-4 left-4 right-4 z-50 mx-auto max-w-6xl flex items-center justify-between px-5 py-3">
    {{-- Logo --}}
    <a href="#" class="flex items-center gap-2.5 group cursor-pointer hover:scale-105 transition-transform">
        <div class="w-10 h-10 flex items-center justify-center flex-shrink-0 rounded-2xl overflow-hidden">
            <img src="/images/planova-logo.png" alt="Planova" class="w-full h-full object-contain">
        </div>
        <span class="text-xl font-bold tracking-tight text-primary-dark hidden sm:inline">Plano<span class="text-primary">va</span></span>
    </a>

    {{-- Desktop Nav --}}
    <div class="hidden md:flex items-center gap-7">
        <a href="#features" class="text-sm font-bold text-text-muted hover:text-primary transition-colors">Fitur</a>
        <a href="#finance" class="text-sm font-bold text-text-muted hover:text-primary transition-colors">Keuangan</a>
        <a href="#analytics" class="text-sm font-bold text-text-muted hover:text-primary transition-colors">Analitik</a>
        <a href="#workflow" class="text-sm font-bold text-text-muted hover:text-primary transition-colors">Workflow</a>
    </div>

    {{-- CTA --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-primary-dark hover:text-primary transition-colors">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="clay-btn px-5 py-2.5 text-sm hidden sm:inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            Mulai Gratis
        </a>
        <button id="mobile-menu-toggle" class="md:hidden clay-btn w-10 h-10 flex items-center justify-center p-0" aria-label="Menu" aria-expanded="false">
            <i class="bi bi-list text-xl"></i>
        </button>
    </div>
</nav>

{{-- Mobile Menu --}}
<div id="mobile-menu" class="hidden fixed inset-x-4 top-20 z-40 clay-card p-4 md:hidden">
    <div class="flex flex-col gap-2 text-center">
        <a href="#features" class="py-3 font-bold text-text-main bg-white/60 rounded-xl hover:bg-white transition-colors">Fitur</a>
        <a href="#finance" class="py-3 font-bold text-text-main bg-white/60 rounded-xl hover:bg-white transition-colors">Keuangan</a>
        <a href="#analytics" class="py-3 font-bold text-text-main bg-white/60 rounded-xl hover:bg-white transition-colors">Analitik</a>
        <a href="#workflow" class="py-3 font-bold text-text-main bg-white/60 rounded-xl hover:bg-white transition-colors">Workflow</a>
        <div class="flex gap-2 mt-2">
            <a href="{{ route('login') }}" class="flex-1 clay-btn py-3 text-center text-sm">Masuk</a>
            <a href="{{ route('register') }}" class="flex-1 clay-btn-accent text-white py-3 text-center text-sm font-bold rounded-2xl">Daftar Gratis</a>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════ --}}
<section id="home" class="pt-36 pb-20 lg:pt-48 lg:pb-32 px-6 lg:px-8 max-w-7xl mx-auto relative">
    {{-- Decorative blobs --}}
    <div class="absolute top-24 right-12 w-40 h-40 bg-primary/15 rounded-full filter blur-3xl opacity-80 animate-float pointer-events-none"></div>
    <div class="absolute bottom-16 left-12 w-56 h-56 bg-secondary-light/50 rounded-full filter blur-3xl opacity-60 animate-wobble pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent/5 rounded-full filter blur-3xl pointer-events-none"></div>

    <div class="grid lg:grid-cols-2 gap-14 items-center relative z-10">
        {{-- Left: copy --}}
        <div class="space-y-7 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full font-bold text-primary text-sm shadow-clay-sm reveal">
                <i class="bi bi-stars text-accent"></i> Workspace produktivitas personal
            </div>
            <h1 class="text-5xl lg:text-6xl xl:text-7xl font-extrabold text-primary-dark leading-tight reveal reveal-delay-1">
                Satu tempat<br>
                untuk <span class="text-primary relative inline-block">semua<span class="absolute -bottom-1 left-0 right-0 h-3 bg-primary/10 rounded-full -z-10"></span></span><br>
                produktivitas Anda
            </h1>
            <p class="text-xl text-text-secondary font-body font-bold max-w-lg mx-auto lg:mx-0 reveal reveal-delay-2">
                Planova menggabungkan <strong class="text-primary-dark">task manager</strong>, <strong class="text-primary-dark">keuangan</strong>, <strong class="text-primary-dark">budget</strong>, <strong class="text-primary-dark">dokumen</strong>, dan <strong class="text-primary-dark">analitik</strong> dalam satu workspace yang elegan — tanpa berpindah aplikasi.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start reveal reveal-delay-3">
                <a href="{{ route('register') }}" class="clay-btn-accent text-white px-8 py-4 text-lg font-bold rounded-2xl inline-flex items-center justify-center gap-2">
                    <i class="bi bi-rocket-takeoff"></i> Mulai Gratis Sekarang
                </a>
                <a href="#features" class="clay-card px-8 py-4 text-lg text-primary-dark font-bold text-center inline-flex items-center justify-center gap-2 hover:-translate-y-1">
                    <i class="bi bi-play-circle"></i> Lihat Fitur
                </a>
            </div>
            <div class="flex flex-wrap justify-center lg:justify-start gap-5 text-sm font-bold text-text-muted reveal reveal-delay-3">
                <span class="flex items-center gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Gratis, tanpa kartu kredit</span>
                <span class="flex items-center gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Setup 30 detik</span>
                <span class="flex items-center gap-2"><i class="bi bi-check-circle-fill text-primary"></i> Dark / Light mode</span>
            </div>
        </div>

        {{-- Right: Dashboard Preview Card --}}
        <div class="reveal reveal-delay-2 relative">
            <div class="clay-card p-5 rotate-1 hover:rotate-0 transition-transform duration-500 max-w-md mx-auto">
                {{-- Mini dashboard mockup --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-primary-dark">Planova Dashboard</span>
                    </div>
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span> Live
                    </span>
                </div>
                {{-- Stat mini-cards --}}
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-white/80 rounded-2xl p-3 border border-white shadow-sm">
                        <div class="text-xs text-text-muted font-bold mb-1">Total Tasks</div>
                        <div class="text-2xl font-extrabold text-primary-dark">24</div>
                        <div class="text-xs text-amber-600 font-bold mt-1">3 in progress</div>
                    </div>
                    <div class="bg-white/80 rounded-2xl p-3 border border-white shadow-sm">
                        <div class="text-xs text-text-muted font-bold mb-1">Saldo Bersih</div>
                        <div class="text-2xl font-extrabold text-green-600">+2.4M</div>
                        <div class="text-xs text-green-600 font-bold mt-1">Bulan ini</div>
                    </div>
                </div>
                {{-- Recent task list --}}
                <div class="bg-white/70 rounded-2xl p-3 border border-white space-y-2.5 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400 flex-shrink-0"></span>
                        <span class="text-sm font-bold text-primary-dark flex-1 truncate">Review laporan bulanan</span>
                        <span class="text-xs text-text-muted">Hari ini</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>
                        <span class="text-sm font-bold text-primary-dark flex-1 truncate">Setup budget Mei</span>
                        <span class="text-xs text-green-600 font-bold">Done</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-surface-500 flex-shrink-0"></span>
                        <span class="text-sm font-bold text-text-secondary flex-1 truncate">Upload invoice Q2</span>
                        <span class="text-xs text-text-muted">Besok</span>
                    </div>
                </div>
                {{-- Budget progress preview --}}
                <div class="bg-white/70 rounded-2xl p-3 border border-white">
                    <div class="flex justify-between text-xs font-bold text-text-secondary mb-1.5">
                        <span>Budget Makan</span><span>Rp 380K / 500K</span>
                    </div>
                    <div class="progress-track" style="height:10px;">
                        <div class="progress-fill" style="width:76%"></div>
                    </div>
                </div>
            </div>
            {{-- Decorative badge --}}
            <div class="absolute -bottom-5 -right-4 bg-accent text-white text-sm font-extrabold px-4 py-2 rounded-2xl shadow-clay-accent rotate-3 animate-bounce-soft z-10">All-in-One!</div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FEATURE OVERVIEW STRIP
     ═══════════════════════════════════════════════ --}}
<section class="py-10 bg-white/60 border-y border-white/80">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
            @foreach([
                ['bi-check2-square', 'Tasks', 'text-primary'],
                ['bi-cash-coin', 'Finance', 'text-green-600'],
                ['bi-bullseye', 'Budget', 'text-amber-600'],
                ['bi-folder2-open', 'Documents', 'text-blue-600'],
                ['bi-graph-up-arrow', 'Analytics', 'text-violet-600'],
                ['bi-person-gear', 'Profile', 'text-text-muted'],
            ] as [$icon, $label, $color])
            <div class="flex flex-col items-center gap-2 reveal">
                <div class="w-12 h-12 rounded-2xl bg-white shadow-clay-sm flex items-center justify-center">
                    <i class="bi {{ $icon }} text-xl {{ $color }}"></i>
                </div>
                <span class="text-sm font-bold text-text-secondary">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FEATURES SECTION — Tasks & Documents
     ═══════════════════════════════════════════════ --}}
<section id="features" class="py-24 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-full font-bold text-primary text-sm mb-4">
                <i class="bi bi-check2-all"></i> Kelola Tugas dengan Mudah
            </div>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-primary-dark mb-4">Task Manager yang<br>benar-benar bekerja</h2>
            <p class="text-xl text-text-secondary font-body font-bold max-w-2xl mx-auto">Buat, kelola, dan selesaikan task dengan editor blok bergaya Notion, deadline tracking, dan filter status yang intuitif.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
            {{-- Feature visual --}}
            <div class="reveal relative">
                <div class="clay-card p-6 max-w-lg mx-auto">
                    <div class="flex items-center justify-between mb-5">
                        <h4 class="font-extrabold text-primary-dark text-lg">Tasks Aktif</h4>
                        <button class="clay-btn px-3 py-1.5 text-xs">+ Task Baru</button>
                    </div>
                    {{-- Filter tabs --}}
                    <div class="flex gap-2 mb-4">
                        <span class="px-3 py-1 bg-primary text-white text-xs font-bold rounded-full">Semua</span>
                        <span class="px-3 py-1 bg-white text-text-muted text-xs font-bold rounded-full">Todo</span>
                        <span class="px-3 py-1 bg-white text-text-muted text-xs font-bold rounded-full">In Progress</span>
                        <span class="px-3 py-1 bg-white text-text-muted text-xs font-bold rounded-full">Selesai</span>
                    </div>
                    {{-- Task rows --}}
                    <div class="space-y-2.5">
                        @foreach([
                            ['Design sprint review', 'In Progress', 'bg-amber-100 text-amber-700', '15 Jun', false],
                            ['Laporan keuangan Q2', 'Selesai', 'bg-green-100 text-green-700', '10 Jun', false],
                            ['Update dokumentasi API', 'Todo', 'bg-slate-100 text-slate-600', '20 Jun', false],
                            ['Bayar tagihan server', 'Todo', 'bg-red-100 text-red-600', '8 Jun', true],
                        ] as [$title, $status, $badgeClass, $date, $overdue])
                        <div class="flex items-center gap-3 bg-white/80 rounded-xl px-3 py-2.5 border border-white">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeClass }} flex-shrink-0">{{ $status }}</span>
                            <span class="text-sm font-bold text-primary-dark flex-1 truncate {{ $overdue ? 'line-through opacity-60' : '' }}">{{ $title }}</span>
                            <span class="text-xs font-bold flex-shrink-0 {{ $overdue ? 'text-red-500' : 'text-text-muted' }}">{{ $date }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Copy --}}
            <div class="space-y-6 text-center lg:text-left reveal reveal-delay-1">
                <h3 class="text-3xl font-extrabold text-primary-dark">Pantau semua task<br>dari satu tampilan</h3>
                <p class="text-lg text-text-secondary font-body font-bold">Filter berdasarkan status, tandai overdue secara otomatis, dan buka setiap task untuk menulis catatan detail menggunakan block editor bergaya Notion.</p>
                <ul class="space-y-3 text-left inline-block">
                    @foreach([
                        ['bi-check-circle-fill text-primary', 'Status: Todo, In Progress, Selesai'],
                        ['bi-check-circle-fill text-primary', 'Due date & deteksi overdue otomatis'],
                        ['bi-check-circle-fill text-primary', 'Block editor: teks, heading, checklist, tabel'],
                        ['bi-check-circle-fill text-primary', 'Filter & sortir cepat dengan satu klik'],
                    ] as [$icon, $text])
                    <li class="flex items-center gap-3 font-bold text-text-secondary">
                        <i class="bi {{ $icon }} flex-shrink-0"></i> {{ $text }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Documents feature --}}
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Copy first on mobile --}}
            <div class="space-y-6 text-center lg:text-left order-2 lg:order-1 reveal">
                <h3 class="text-3xl font-extrabold text-primary-dark">Perpustakaan dokumen<br>selalu tersedia</h3>
                <p class="text-lg text-text-secondary font-body font-bold">Upload, simpan, dan akses semua file Anda — PDF, Word, Excel, PowerPoint, gambar, hingga ZIP — langsung dari workspace tanpa perlu aplikasi pihak ketiga.</p>
                <ul class="space-y-3 text-left inline-block">
                    @foreach([
                        ['bi-check-circle-fill text-primary', 'Mendukung 10+ format file'],
                        ['bi-check-circle-fill text-primary', 'Preview & download instan'],
                        ['bi-check-circle-fill text-primary', 'Pencarian dokumen real-time'],
                        ['bi-check-circle-fill text-primary', 'Monitoring ukuran storage'],
                    ] as [$icon, $text])
                    <li class="flex items-center gap-3 font-bold text-text-secondary">
                        <i class="bi {{ $icon }} flex-shrink-0"></i> {{ $text }}
                    </li>
                    @endforeach
                </ul>
            </div>
            {{-- Document grid mockup --}}
            <div class="reveal reveal-delay-1 order-1 lg:order-2">
                <div class="clay-card p-5 max-w-lg mx-auto">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-extrabold text-primary-dark">Documents</h4>
                        <span class="text-xs text-text-muted font-bold bg-white/80 px-3 py-1 rounded-full">3 file • 4.2 MB</span>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        @foreach([
                            ['bi-file-earmark-pdf text-red-500', 'Laporan.pdf', '1.2 MB'],
                            ['bi-file-earmark-excel text-green-600', 'Budget.xlsx', '380 KB'],
                            ['bi-file-earmark-word text-blue-600', 'Proposal.docx', '2.6 MB'],
                        ] as [$icon, $name, $size])
                        <div class="bg-white/80 rounded-2xl p-3 text-center border border-white flex flex-col items-center gap-2">
                            <i class="bi {{ $icon }} text-3xl"></i>
                            <span class="text-xs font-bold text-primary-dark leading-tight">{{ $name }}</span>
                            <span class="text-xs text-text-muted">{{ $size }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2 bg-white/70 rounded-xl px-3 py-2 border border-white">
                        <i class="bi bi-search text-primary/50 text-sm"></i>
                        <span class="text-sm text-text-muted font-bold">Cari dokumen...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FINANCE SECTION
     ═══════════════════════════════════════════════ --}}
<section id="finance" class="py-24 bg-white/50 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            {{-- Finance mockup --}}
            <div class="reveal relative">
                <div class="clay-card p-5 max-w-lg mx-auto">
                    {{-- Summary row --}}
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="bg-green-50 rounded-2xl p-3 text-center border border-green-100">
                            <div class="text-xs font-bold text-green-700 mb-1">Pemasukan</div>
                            <div class="text-lg font-extrabold text-green-600">+5.2M</div>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-3 text-center border border-red-100">
                            <div class="text-xs font-bold text-red-600 mb-1">Pengeluaran</div>
                            <div class="text-lg font-extrabold text-red-500">-2.8M</div>
                        </div>
                        <div class="bg-primary/5 rounded-2xl p-3 text-center border border-primary/10">
                            <div class="text-xs font-bold text-primary mb-1">Saldo Bersih</div>
                            <div class="text-lg font-extrabold text-primary">+2.4M</div>
                        </div>
                    </div>
                    {{-- Transaction list --}}
                    <div class="space-y-2">
                        @foreach([
                            ['Gaji Mei', 'income', '+Rp 5.200.000', 'Karir', '1 Mei'],
                            ['Sewa Kos', 'expense', '-Rp 1.200.000', 'Tempat Tinggal', '2 Mei'],
                            ['Belanja', 'expense', '-Rp 380.000', 'Kebutuhan', '5 Mei'],
                            ['Freelance', 'income', '+Rp 800.000', 'Proyek', '8 Mei'],
                        ] as [$desc, $type, $amount, $cat, $date])
                        <div class="flex items-center gap-3 bg-white/80 rounded-xl px-3 py-2.5 border border-white">
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full flex-shrink-0 {{ $type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                {{ $type === 'income' ? 'In' : 'Out' }}
                            </span>
                            <span class="text-sm font-bold text-primary-dark flex-1 truncate">{{ $desc }}</span>
                            <span class="text-xs text-text-muted flex-shrink-0">{{ $cat }}</span>
                            <span class="text-sm font-extrabold flex-shrink-0 {{ $type === 'income' ? 'text-green-600' : 'text-red-500' }}">{{ $amount }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- Budget progress card --}}
                <div class="clay-card p-4 max-w-lg mx-auto mt-4 -rotate-1 hover:rotate-0 transition-transform">
                    <div class="text-sm font-extrabold text-primary-dark mb-3">Budget Bulan Ini</div>
                    @foreach([
                        ['Makan & Minum', 380000, 600000, 'bg-primary'],
                        ['Transportasi', 150000, 200000, 'bg-amber-500'],
                        ['Hiburan', 80000, 300000, 'bg-violet-500'],
                    ] as [$name, $spent, $limit, $color])
                    @php $pct = round(($spent/$limit)*100); @endphp
                    <div class="mb-3">
                        <div class="flex justify-between text-xs font-bold text-text-secondary mb-1">
                            <span>{{ $name }}</span>
                            <span>{{ $pct }}%</span>
                        </div>
                        <div class="h-2 rounded-full bg-surface-100 overflow-hidden">
                            <div class="{{ $color }} h-full rounded-full" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Copy --}}
            <div class="space-y-6 text-center lg:text-left reveal reveal-delay-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full font-bold text-green-700 text-sm">
                    <i class="bi bi-cash-coin"></i> Keuangan & Budget
                </div>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-primary-dark">Catat keuangan,<br>atur budget,<br>kontrol pengeluaran</h2>
                <p class="text-xl text-text-secondary font-body font-bold">Lacak setiap pemasukan dan pengeluaran, kategorikan transaksi, dan set limit budget bulanan dengan progress bar yang terus update secara real-time.</p>
                <ul class="space-y-3 text-left inline-block">
                    @foreach([
                        ['bi-check-circle-fill text-primary', 'Catat income & expense dengan kategori'],
                        ['bi-check-circle-fill text-primary', 'Filter berdasarkan tipe, kategori, dan bulan'],
                        ['bi-check-circle-fill text-primary', 'Budget limit dengan visual progress bar'],
                        ['bi-check-circle-fill text-primary', 'Kalkulasi saldo bersih otomatis'],
                    ] as [$icon, $text])
                    <li class="flex items-center gap-3 font-bold text-text-secondary">
                        <i class="bi {{ $icon }} flex-shrink-0"></i> {{ $text }}
                    </li>
                    @endforeach
                </ul>
                <div class="pt-2">
                    <a href="{{ route('register') }}" class="clay-btn-accent text-white px-7 py-3.5 text-base font-bold rounded-2xl inline-flex items-center gap-2">
                        <i class="bi bi-arrow-right"></i> Mulai Lacak Keuangan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     ANALYTICS SECTION
     ═══════════════════════════════════════════════ --}}
<section id="analytics" class="py-24 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-violet-50 rounded-full font-bold text-violet-700 text-sm mb-4">
                <i class="bi bi-graph-up-arrow"></i> Analytics & Insights
            </div>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-primary-dark mb-4">Data nyata,<br>keputusan lebih cerdas</h2>
            <p class="text-xl text-text-secondary font-body font-bold max-w-2xl mx-auto">Dashboard analitik interaktif memberi Anda gambaran lengkap: tren keuangan 6 bulan, distribusi pengeluaran per kategori, dan tingkat penyelesaian task.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6 mb-12">
            {{-- KPI cards --}}
            @foreach([
                ['bi-wallet2', 'Saldo Awal Bulan', 'Sisa dari bulan sebelumnya', 'bg-primary/10 text-primary'],
                ['bi-graph-up', 'Pemasukan Bulan Ini', 'Total uang yang diterima', 'bg-green-100 text-green-700'],
                ['bi-graph-down', 'Pengeluaran Bulan Ini', 'Total uang yang digunakan', 'bg-red-100 text-red-600'],
                ['bi-cash-stack', 'Saldo Saat Ini', 'Saldo yang masih tersedia', 'bg-amber-100 text-amber-700'],
                ['bi-check2-all', 'Progress Task', 'Persentase task selesai', 'bg-violet-100 text-violet-700'],
            ] as $i => [$icon, $label, $desc, $iconClass])
            <div class="clay-card p-5 reveal {{ $i > 2 ? 'reveal-delay-1' : '' }}">
                <div class="w-10 h-10 rounded-xl {{ $iconClass }} flex items-center justify-center mb-3">
                    <i class="bi {{ $icon }} text-lg"></i>
                </div>
                <div class="text-base font-extrabold text-primary-dark mb-1">{{ $label }}</div>
                <div class="text-sm text-text-muted font-bold">{{ $desc }}</div>
            </div>
            @endforeach

            {{-- Chart preview card --}}
            <div class="clay-card p-5 reveal reveal-delay-1 lg:col-span-3">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-extrabold text-primary-dark">Laporan Saldo 6 Bulan</h4>
                        <p class="text-sm text-text-muted font-bold">Saldo akhir otomatis jadi saldo awal bulan berikutnya</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-primary bg-primary/10 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse inline-block"></span> Interactive Chart
                    </div>
                </div>
                {{-- Fake bar chart --}}
                <div class="flex items-end gap-3 h-28 px-2">
                    @foreach([
                        ['Jan', 65, 40], ['Feb', 75, 55], ['Mar', 55, 70],
                        ['Apr', 85, 45], ['Mei', 90, 60], ['Jun', 70, 35],
                    ] as [$month, $incPct, $expPct])
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full flex items-end gap-0.5 h-20">
                            <div class="flex-1 bg-emerald-400 rounded-t-lg opacity-80 transition-all" style="height:{{ $incPct }}%"></div>
                            <div class="flex-1 bg-red-400 rounded-t-lg opacity-80 transition-all" style="height:{{ $expPct }}%"></div>
                        </div>
                        <div class="text-xs font-bold text-text-muted">{{ $month }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="flex gap-4 mt-3 justify-center">
                    <span class="flex items-center gap-1.5 text-xs font-bold text-text-muted"><span class="w-3 h-3 rounded bg-emerald-400 inline-block"></span> Pemasukan</span>
                    <span class="flex items-center gap-1.5 text-xs font-bold text-text-muted"><span class="w-3 h-3 rounded bg-red-400 inline-block"></span> Pengeluaran</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     WORKFLOW / HOW IT WORKS
     ═══════════════════════════════════════════════ --}}
<section id="workflow" class="py-24 bg-white/50 relative">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent/10 rounded-full font-bold text-accent text-sm mb-4">
                <i class="bi bi-lightning-charge-fill"></i> Cara Kerja
            </div>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-primary-dark mb-4">Dari daftar tugas ke laporan keuangan<br>— semua dalam satu alur</h2>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            @foreach([
                ['1', 'bi-person-plus', 'Daftar & Login', 'Buat akun gratis dalam 30 detik. Tidak perlu kartu kredit.', 'bg-primary/10 text-primary'],
                ['2', 'bi-check2-square', 'Buat Tasks', 'Tambah task, set deadline, tulis catatan detail di block editor.', 'bg-amber-100 text-amber-700'],
                ['3', 'bi-cash-coin', 'Catat Keuangan', 'Log pemasukan & pengeluaran, set budget, pantau saldo.', 'bg-green-100 text-green-700'],
                ['4', 'bi-graph-up-arrow', 'Lihat Analitik', 'Dashboard analitik otomatis merangkum semua data Anda.', 'bg-violet-100 text-violet-700'],
            ] as [$step, $icon, $title, $desc, $iconClass])
            <div class="clay-card p-6 text-center reveal {{ $loop->index > 0 ? 'reveal-delay-'.$loop->index : '' }}">
                <div class="w-10 h-10 rounded-full bg-primary text-white font-extrabold flex items-center justify-center text-base mx-auto mb-3">{{ $step }}</div>
                <div class="w-12 h-12 rounded-2xl {{ $iconClass }} flex items-center justify-center mx-auto mb-4">
                    <i class="bi {{ $icon }} text-xl"></i>
                </div>
                <h3 class="text-base font-extrabold text-primary-dark mb-2">{{ $title }}</h3>
                <p class="text-sm text-text-secondary font-body font-bold">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FEATURE HIGHLIGHT GRID
     ═══════════════════════════════════════════════ --}}
<section class="py-24 relative">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-primary-dark mb-4">Semua yang Anda butuhkan,<br>dalam satu workspace</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['bi-check2-square', 'Task Manager Lengkap', 'CRUD task dengan status tracking, due date, overdue alert, dan block editor Notion-like untuk mencatat detail pekerjaan.', 'bg-primary/10 text-primary'],
                ['bi-cash-coin', 'Pencatatan Keuangan', 'Catat setiap pemasukan dan pengeluaran dengan kategori, filter multi-dimensi, dan kalkulasi saldo otomatis.', 'bg-green-100 text-green-600'],
                ['bi-bullseye', 'Budget Planner', 'Set limit pengeluaran per kategori setiap bulan dan pantau sisa budget dengan progress bar yang akurat.', 'bg-amber-100 text-amber-700'],
                ['bi-folder2-open', 'Document Library', 'Upload dan simpan semua jenis file — PDF, Word, Excel, PPT, gambar, ZIP — dengan preview dan download instan.', 'bg-blue-100 text-blue-600'],
                ['bi-graph-up-arrow', 'Analytics Dashboard', 'Chart interaktif: tren 6 bulan keuangan, distribusi pengeluaran per kategori, dan completion rate task bulanan.', 'bg-violet-100 text-violet-700'],
                ['bi-moon-stars', 'Dark & Light Mode', 'Tampilan yang nyaman di segala kondisi pencahayaan dengan toggle dark/light mode yang smooth dan konsisten.', 'bg-slate-100 text-slate-600'],
            ] as [$icon, $title, $desc, $iconClass])
            <div class="clay-card p-6 reveal {{ $loop->index > 2 ? 'reveal-delay-1' : '' }}">
                <div class="w-12 h-12 rounded-2xl {{ $iconClass }} flex items-center justify-center mb-4">
                    <i class="bi {{ $icon }} text-xl"></i>
                </div>
                <h3 class="text-lg font-extrabold text-primary-dark mb-2">{{ $title }}</h3>
                <p class="text-sm text-text-secondary font-body font-bold leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     CTA FINAL
     ═══════════════════════════════════════════════ --}}
<section class="py-24 px-6 lg:px-8">
    <div class="max-w-5xl mx-auto relative reveal">
        <div class="bg-primary rounded-[2.5rem] p-12 lg:p-16 text-center text-white overflow-hidden relative shadow-clay-lg">
            {{-- Decorative blobs --}}
            <div class="absolute top-8 left-8 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute bottom-8 right-10 w-40 h-40 bg-accent/30 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute top-1/2 right-8 w-20 h-20 bg-secondary/20 rounded-full blur-xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6 max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 rounded-full font-bold text-white/90 text-sm mb-2">
                    <i class="bi bi-rocket-takeoff"></i> Gratis, tanpa batas waktu
                </div>
                <h2 class="text-4xl lg:text-6xl font-extrabold leading-tight">
                    Mulai kelola hidup Anda<br>dengan lebih teratur
                </h2>
                <p class="text-xl font-body font-bold text-white/85 max-w-2xl mx-auto">
                    Daftar sekarang dan langsung akses semua fitur Planova — task manager, keuangan, budget, dokumen, dan analitik — dalam satu workspace premium.
                </p>
                <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="clay-btn-accent text-white px-10 py-5 text-xl font-extrabold rounded-2xl inline-flex items-center justify-center gap-2 hover:scale-105 transition-transform">
                        <i class="bi bi-person-plus"></i> Daftar Gratis — Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="bg-white/15 text-white px-8 py-5 text-base font-bold rounded-2xl inline-flex items-center justify-center gap-2 hover:bg-white/25 transition-colors border border-white/30">
                        Sudah punya akun? Masuk
                    </a>
                </div>
                <p class="text-sm font-bold text-white/60 mt-4">
                    <i class="bi bi-shield-lock-fill mr-1"></i> Data Anda aman. Tidak ada spam. Tidak ada iklan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FOOTER
     ═══════════════════════════════════════════════ --}}
<footer class="py-12 bg-white/60 border-t-2 border-white/80">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <a href="#" class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 rounded-xl bg-primary text-white font-bold flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <span class="text-lg font-bold text-primary-dark">Plano<span class="text-primary">va</span></span>
        </a>

        <div class="flex flex-wrap justify-center gap-6 text-sm font-bold text-text-muted">
            <a href="#features" class="hover:text-primary transition-colors">Fitur</a>
            <a href="#finance" class="hover:text-primary transition-colors">Keuangan</a>
            <a href="#analytics" class="hover:text-primary transition-colors">Analitik</a>
            <a href="#workflow" class="hover:text-primary transition-colors">Cara Kerja</a>
            <a href="{{ route('login') }}" class="hover:text-primary transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="hover:text-primary transition-colors">Daftar</a>
        </div>

        <div class="text-sm font-bold text-text-muted">
            &copy; {{ date('Y') }} Planova. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
