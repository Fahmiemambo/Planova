<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gratis — Planova</title>
    <meta name="description" content="Buat akun Planova dan mulai kelola produktivitas Anda">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center p-6 relative overflow-hidden"
    style="background-color:#F0FDFA; background-image: radial-gradient(circle at 20% 40%, rgba(45,212,191,0.18) 0%, transparent 50%), radial-gradient(circle at 80% 70%, rgba(249,115,22,0.10) 0%, transparent 45%); background-attachment: fixed;">

    {{-- Decorative blobs --}}
    <div class="absolute top-16 right-16 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-16 left-16 w-56 h-56 bg-secondary-light/40 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Back link --}}
    <a href="{{ url('/') }}" class="absolute top-5 left-5 flex items-center gap-2 text-sm font-bold text-text-muted hover:text-primary transition-colors z-10">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali
    </a>

    <div class="w-full max-w-md relative z-10">
        {{-- Card --}}
        <div class="clay-card p-8 sm:p-10 animate-fade-in-up">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-8 w-fit">
                <div class="w-10 h-10 flex items-center justify-center rounded-2xl overflow-hidden">
                    <img src="/images/planova-logo.png" alt="Planova" class="w-full h-full object-contain">
                </div>
                <span class="font-extrabold text-2xl tracking-tight text-primary-dark">Plano<span class="text-primary">va</span></span>
            </a>

            <h1 class="text-2xl font-extrabold mb-1 text-primary-dark">Buat Akun Gratis</h1>
            <p class="text-sm font-bold text-text-muted mb-7">Mulai perjalanan produktivitas Anda bersama Planova.</p>

            {{-- Errors --}}
            @if($errors->any())
                <div class="flex items-start gap-3 p-4 mb-5 rounded-2xl border border-red-200 bg-red-50 text-red-600">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-0.5"></i>
                    <div class="text-sm font-bold space-y-0.5">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="form-label-p">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        class="form-control-p" value="{{ old('name') }}"
                        placeholder="Masukkan nama Anda" required autofocus>
                </div>

                <div>
                    <label for="email" class="form-label-p">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control-p" value="{{ old('email') }}"
                        placeholder="nama@email.com" required>
                </div>

                <div>
                    <label for="password" class="form-label-p">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="form-control-p pr-11" placeholder="Minimal 8 karakter" required>
                        <button type="button" id="toggle-password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-primary transition-colors p-1 focus:outline-none"
                            aria-label="Tampilkan password">
                            <i class="bi bi-eye text-lg" id="toggle-pw-icon"></i>
                        </button>
                    </div>
                    <p class="text-xs font-bold text-text-muted mt-1">Minimal 8 karakter.</p>
                </div>

                <div>
                    <label for="password_confirmation" class="form-label-p">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control-p" placeholder="Ulangi password Anda" required>
                </div>

                <button type="submit" class="btn-planova btn-primary-p w-full justify-center py-3 text-base mt-1">
                    <i class="bi bi-person-plus"></i> Buat Akun
                </button>
            </form>

            <p class="text-center mt-7 text-sm font-bold text-text-muted">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark font-extrabold transition-colors ml-1">
                    Masuk di sini
                </a>
            </p>
        </div>

        {{-- Trust badges --}}
        <div class="mt-5 flex flex-wrap justify-center gap-4 text-xs font-bold text-text-muted">
            <span class="flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Gratis selamanya
            </span>
            <span class="flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Tanpa kartu kredit
            </span>
            <span class="flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0D9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Data aman & privat
            </span>
        </div>
    </div>

<script>
    document.getElementById('toggle-password')?.addEventListener('click', function () {
        const pw = document.getElementById('password');
        const icon = document.getElementById('toggle-pw-icon');
        pw.type = pw.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>
