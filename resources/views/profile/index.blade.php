@extends('layouts.app')

@section('title', 'Profile')
@section('page_title', 'Profile & Settings')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-text-main dark:text-text-darkMain mb-1">Profile & Settings</h1>
    <p class="text-sm text-text-muted dark:text-text-darkMuted">Kelola informasi akun Anda.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Sidebar Profile Nav (mimicking settings nav) --}}
    <div class="col-span-1">
        <div class="pcard p-2 space-y-1 animate-fade-in-up">
            <a href="#general" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium bg-surface-100 dark:bg-dark-surface2 text-text-main dark:text-text-darkMain">
                <i class="bi bi-person text-lg"></i> General
            </a>
            <a href="#security" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-text-secondary dark:text-text-darkSecondary hover:bg-surface-100 dark:hover:bg-dark-surface2 hover:text-text-main dark:hover:text-text-darkMain transition-colors">
                <i class="bi bi-shield-lock text-lg"></i> Security
            </a>
            <a href="#preferences" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-text-secondary dark:text-text-darkSecondary hover:bg-surface-100 dark:hover:bg-dark-surface2 hover:text-text-main dark:hover:text-text-darkMain transition-colors">
                <i class="bi bi-sliders text-lg"></i> Preferences
            </a>
        </div>
    </div>

    {{-- Main Settings Content --}}
    <div class="col-span-1 md:col-span-2 space-y-6">

        {{-- General Info --}}
        <div id="general" class="pcard animate-fade-in-up" style="animation-delay: 50ms;">
            <div class="border-b border-surface-500 dark:border-dark-border pb-4 mb-6">
                <h2 class="text-lg font-semibold text-text-main dark:text-text-darkMain">Informasi Dasar</h2>
                <p class="text-sm text-text-muted dark:text-text-darkMuted">Perbarui nama dan alamat email akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf @method('PUT')
                
                <div class="flex flex-col sm:flex-row sm:items-end gap-6">
                    <div class="relative">
                        @if(\App\Helpers\AvatarHelper::hasAvatar($user))
                            <img src="{{ \App\Helpers\AvatarHelper::getAvatarUrl($user) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-4 border-surface-200 dark:border-dark-surface shadow-sm">
                        @else
                            <div class="w-20 h-20 rounded-full bg-primary-light text-primary dark:bg-primary/20 dark:text-primary-light flex items-center justify-center text-3xl font-bold border-4 border-surface-200 dark:border-dark-surface shadow-sm">
                                {{ \App\Helpers\AvatarHelper::getInitials($user) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*">
                        <button type="button" class="btn-planova btn-secondary-p btn-sm-p" onclick="document.getElementById('avatar-input').click();">
                            <i class="bi bi-upload"></i> Ubah Avatar
                        </button>
                        @if(\App\Helpers\AvatarHelper::hasAvatar($user))
                            <form method="POST" action="{{ route('profile.avatar.delete') }}" class="inline" onsubmit="return confirm('Hapus avatar?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-planova btn-secondary-p btn-sm-p text-red-600 hover:bg-red-50">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Avatar upload handling --}}
                <script>
                    document.getElementById('avatar-input').addEventListener('change', function(e) {
                        if (this.files && this.files[0]) {
                            const formData = new FormData();
                            formData.append('avatar', this.files[0]);
                            
                            fetch('{{ route("profile.avatar.upload") }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) throw response;
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengupload avatar. Pastikan file berupa gambar (max 2MB).');
                            });
                        }
                    });
                </script>

                <div>
                    <label for="name" class="form-label-p">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control-p max-w-md" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="email" class="form-label-p">Email</label>
                    <input type="email" id="email" name="email" class="form-control-p max-w-md" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-planova btn-primary-p">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- Security --}}
        <div id="security" class="pcard animate-fade-in-up" style="animation-delay: 100ms;">
            <div class="border-b border-surface-500 dark:border-dark-border pb-4 mb-6">
                <h2 class="text-lg font-semibold text-text-main dark:text-text-darkMain">Ubah Password</h2>
                <p class="text-sm text-text-muted dark:text-text-darkMuted">Pastikan akun Anda menggunakan password panjang dan acak untuk keamanan.</p>
            </div>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label for="current_password" class="form-label-p">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="form-control-p max-w-md" required>
                    @error('current_password')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="password" class="form-label-p">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control-p max-w-md" required>
                    @error('password')<div class="text-sm text-red-500 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label-p">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-p max-w-md" required>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-planova btn-primary-p">Update Password</button>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="pcard border-red-200 dark:border-red-900/50 bg-red-50/30 dark:bg-red-900/10 animate-fade-in-up" style="animation-delay: 150ms;">
            <div class="border-b border-red-200 dark:border-red-900/50 pb-4 mb-6">
                <h2 class="text-lg font-semibold text-red-600 dark:text-red-400">Hapus Akun</h2>
                <p class="text-sm text-text-muted dark:text-text-darkMuted">Sekali Anda menghapus akun, semua sumber daya dan data akan dihapus secara permanen.</p>
            </div>
            
            <button type="button" class="btn-planova btn-danger-p" onclick="alert('Fitur ini dinonaktifkan di mode demo.')">
                Hapus Akun Permanen
            </button>
        </div>

    </div>

</div>
@endsection
