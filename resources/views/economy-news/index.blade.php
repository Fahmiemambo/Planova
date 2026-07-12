@extends('layouts.app')

@section('title', 'Berita Ekonomi')
@section('body_class', 'page-economy-news')
@section('page_title', 'Berita Ekonomi Terkini')

@section('content')
<div class="mb-7 flex items-center justify-between gap-4 flex-wrap">
    <div>
        <h1 class="text-3xl font-extrabold text-primary-dark leading-tight mb-1">Berita Ekonomi Terkini</h1>
        <p class="text-sm font-bold text-text-muted">Ringkasan headline ekonomi terbaru untuk membantu Anda tetap up-to-date.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    @foreach($economyNews as $news)
        <a href="{{ $news['url'] }}" class="economy-news-link pcard animate-stagger-card opacity-0 bg-white/80 border border-white/80 rounded-3xl p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-3 gap-3">
                <span class="text-xs uppercase tracking-[0.24em] font-bold text-primary/70">{{ $news['source'] }}</span>
                <span class="text-xs text-text-muted">{{ $news['date'] }}</span>
            </div>
            <h2 class="text-xl font-extrabold text-primary-dark mb-3">{{ $news['title'] }}</h2>
            <p class="text-sm text-text-muted leading-relaxed">{{ $news['summary'] }}</p>
            <div class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-primary">
                <span>Baca selengkapnya</span>
                <i class="bi bi-arrow-right"></i>
            </div>
        </a>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const overlay = document.getElementById('redirect-loader-overlay');
        const countdown = document.getElementById('redirect-countdown');
        let intervalId;

        const showOverlay = (seconds) => {
            if (!overlay || !countdown) return;
            countdown.textContent = seconds.toString();
            overlay.style.display = 'flex';
            overlay.classList.remove('hidden');
            overlay.style.opacity = '0';
            overlay.style.transition = 'opacity 0.3s ease';
            requestAnimationFrame(() => overlay.style.opacity = '1');
        };

        const hideOverlay = () => {
            if (!overlay) return;
            overlay.style.opacity = '0';
            clearInterval(intervalId);
            setTimeout(() => {
                overlay.style.display = 'none';
                overlay.classList.add('hidden');
            }, 300);
        };

        document.querySelectorAll('.economy-news-link').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const href = this.getAttribute('href');
                if (!href) return;

                let secondsLeft = 5;
                showOverlay(secondsLeft);

                intervalId = setInterval(() => {
                    secondsLeft -= 1;
                    if (countdown) countdown.textContent = secondsLeft.toString();
                    if (secondsLeft <= 0) {
                        clearInterval(intervalId);
                        window.location.href = href;
                    }
                }, 1000);
            });
        });
    });
</script>
@endpush
