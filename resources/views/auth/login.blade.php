<!DOCTYPE html>
<html lang="id" class="transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Planova</title>
    <meta name="description" content="Login ke Planova — workspace produktivitas pribadi Anda">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-surface-100 dark:bg-dark-bg text-text-main dark:text-text-darkMain antialiased flex items-center justify-center min-h-screen p-6 transition-colors">

    <div class="w-full max-w-md bg-surface-200 dark:bg-dark-surface border border-surface-500 dark:border-dark-border rounded-2xl shadow-lg dark:shadow-dark-lg p-8 sm:p-10 animate-fade-in-up">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-sm">P</div>
            <span class="font-bold text-2xl tracking-tight text-text-main dark:text-text-darkMain">Planova</span>
        </div>

        <h1 class="text-2xl font-bold mb-2 text-text-main dark:text-text-darkMain">Selamat Datang</h1>
        <p class="text-sm text-text-muted dark:text-text-darkMuted mb-8">Masuk untuk melanjutkan ke workspace Anda.</p>

        {{-- Flash errors --}}
        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 p-4 rounded-lg mb-6 flex items-start gap-3">
                <i class="bi bi-exclamation-circle-fill mt-0.5"></i>
                <span class="text-sm font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="form-label-p">Email</label>
                <input type="email" id="email" name="email" class="form-control-p" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
            </div>

            <div>
                <label for="password" class="form-label-p">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="form-control-p pr-10" placeholder="Masukkan password" required>
                    <button type="button" id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-darkMuted hover:text-text-main dark:hover:text-text-darkMain focus:outline-none p-1 transition-colors" aria-label="Toggle password visibility">
                        <i class="bi bi-eye text-lg block" id="toggle-pw-icon"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-2">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-primary bg-surface-200 border-surface-500 rounded focus:ring-primary dark:bg-dark-surface dark:border-dark-border dark:checked:bg-primary accent-primary cursor-pointer">
                <label for="remember" class="text-sm text-text-secondary dark:text-text-darkSecondary cursor-pointer">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-planova btn-primary-p w-full justify-center py-2.5 text-base mt-2">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk
            </button>
        </form>

        <p class="text-center mt-8 text-sm text-text-muted dark:text-text-darkMuted">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary hover:text-primary-hover font-medium transition-colors">Daftar sekarang</a>
        </p>

    </div>

<script>
    document.getElementById('toggle-password')?.addEventListener('click', function () {
        const pwInput = document.getElementById('password');
        const icon    = document.getElementById('toggle-pw-icon');
        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pwInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
</body>
</html>
