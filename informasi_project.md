# Informasi Project Planova

## 1. Ringkasan Project
Planova adalah workspace produktivitas berbasis web yang menggabungkan: tugas, catatan, keuangan, berita ekonomi, dokumen, dan analitik.

Aplikasi dikembangkan dengan Laravel 10 untuk backend, Blade + Tailwind CSS untuk frontend, dan Vite sebagai bundler asset.

## 2. Output Utama dan Kode Terkait
Berikut adalah keluaran utama aplikasi dan file kode yang menghasilkannya.

### 2.1 Landing Page
- Output: halaman awal publik.
- Kode: `resources/views/landing.blade.php`
- Route: `/`
- Keterangan: halaman statis yang ditampilkan sebelum pengguna masuk.

### 2.2 Dashboard
- Output: ringkasan tugas, keuangan, dan anggaran pengguna.
- Kode: `app/Http/Controllers/DashboardController.php`
- View: `resources/views/dashboard/index.blade.php`
- Proses:
  1. User mengakses `/dashboard`
  2. Controller mengumpulkan statistik tugas, pendapatan, pengeluaran, dan anggaran.
  3. Data dikompilasi dan dikirim ke view untuk dirender.

### 2.3 Tasks
- Output: daftar tugas, form pembuatan/edit tugas, detail tugas.
- Kode: `app/Http/Controllers/TaskController.php`
- Views:
  - `resources/views/tasks/index.blade.php`
  - `resources/views/tasks/create.blade.php`
  - `resources/views/tasks/edit.blade.php`
  - `resources/views/tasks/show.blade.php`
- Proses utama:
  - `index()` menampilkan daftar tugas milik pengguna.
  - `store()` membuat tugas baru.
  - `update()` memperbarui tugas.
  - `destroy()` menghapus tugas.
  - `updateStatus()` menerima patch status cepat tanpa form lengkap.

### 2.4 Notes
- Output: halaman daftar catatan dan editor catatan.
- Kode: `app/Http/Controllers/NoteController.php`
- Views: `resources/views/notes/` (index, show, dsb.)
- Proses: CRUD catatan untuk setiap pengguna.

### 2.5 Finance
- Output: manajemen transaksi keuangan dan laporan ringkas.
- Kode: `app/Http/Controllers/FinanceController.php`
- Views: `resources/views/finance/`
- Proses: pembuatan transaksi, pembaharuan, penghapusan, dan tampilan ringkasan.

### 2.6 Economy News
- Output: tampilan berita ekonomi terkini dengan loading redirect pada setiap artikel.
- Kode: `app/Http/Controllers/EconomyNewsController.php`
- View: `resources/views/economy-news/index.blade.php`
- Route: `Route::get('/economy-news', [App\Http\Controllers\EconomyNewsController::class, 'index'])->name('economy-news.index');`
- Proses: mengambil data berita ekonomi dari RSS, merender daftar artikel, dan menampilkan overlay loading saat user klik.

### 2.7 Documents
- Output: tampilan berita ekonomi terkini dengan loading redirect pada setiap artikel.
- Kode: `app/Http/Controllers/EconomyNewsController.php`
- View: `resources/views/economy-news/index.blade.php`
- Route: `Route::get('/economy-news', [App\Http\Controllers\EconomyNewsController::class, 'index'])->name('economy-news.index');`
- Proses: mengambil data berita ekonomi dari RSS, merender daftar artikel, dan menampilkan overlay loading saat user klik.

### 2.8 Documents
- Output: upload, preview, dan download dokumen.
- Kode: `app/Http/Controllers/DocumentController.php`
- Views: `resources/views/documents/`
- Proses: upload file, simpan metadata, preview/unduh kembali.

### 2.8 Analytics
- Output: grafik tren keuangan, tugas, dan metrik produktivitas.
- Kode: `app/Http/Controllers/AnalyticsController.php`
- View: `resources/views/analytics/index.blade.php`
- Proses: mengambil data historis dan menampilkan grafik Chart.js.

### 2.9 Profile & Avatar
- Output: halaman profile user, update profil, update password, upload avatar.
- Kode:
  - `app/Http/Controllers/ProfileController.php`
  - `app/Helpers/AvatarHelper.php`
- Views: `resources/views/profile/index.blade.php`
- Proses avatar:
  1. User memilih file gambar.
  2. JavaScript mengirim file ke route `profile.avatar.upload`.
  3. Controller menyimpan file di disk `public` dan mengupdate kolom `avatar` pada model `User`.
  4. `AvatarHelper::getAvatarUrl()` mengonversi path menjadi URL publik `storage/{path}`.
  5. Laravel mengakses file via symlink `public/storage`.

## 3. Struktur Data dan Model
Model penting di aplikasi ini:
- `app/Models/User.php`
- `app/Models/Task.php`
- `app/Models/Note.php`
- `app/Models/FinanceRecord.php`
- `app/Models/Budget.php`
- `app/Models/Document.php`
- `app/Models/TaskProperty.php`
- `app/Models/TaskPropertyValue.php`

Model-model ini merepresentasikan entitas utama dan hubungan antar data yang digunakan oleh controller.

## 4. Alur Request Umum
1. User mengakses URL.
2. Laravel mencocokkan route di `routes/web.php`.
3. Controller mengambil data dari model atau request.
4. Controller memvalidasi request bila perlu.
5. Data diproses dan disimpan.
6. Controller mengembalikan view Blade atau JSON.
7. Blade menggunakan data untuk merender HTML.
8. Jika diperlukan, JavaScript frontend mengirim request tambahan ke endpoint AJAX.

## 5. Asset & Build
Project menggunakan Vite dan Tailwind CSS.
- File frontend utama berada di `resources/css/` dan `resources/js/`.
- `@vite()` di layout `resources/views/layouts/app.blade.php` memanggil asset build.
- Aset produksi dihasilkan ke `public/build/` saat menjalankan `npm run build`.
- Saat `npm run dev`, Vite menjalankan development server dengan hot reload.

## 6. Setup Khusus Avatar dan File Publik
Agar upload avatar berfungsi di semua perangkat, perlu melakukan:
- `php artisan storage:link`
- Pastikan `public/storage` tersedia dan terhubung ke `storage/app/public`
- Pastikan file permission pada folder `storage/` dan `bootstrap/cache/` memadai

## 7. Koneksi Kode dan Output
| Output | Controller | View | Model | Keterangan |
|---|---|---|---|---|
| Dashboard | `DashboardController` | `dashboard.index` | `Task`, `FinanceRecord`, `Budget` | Ringkasan aktivitas pengguna |
| Tasks | `TaskController` | `tasks.*` | `Task`, `TaskProperty`, `TaskPropertyValue` | CRUD tugas, board/table, status update |
| Notes | `NoteController` | `notes.*` | `Note` | CRUD catatan |
| Finance | `FinanceController` | `finance.*` | `FinanceRecord`, `Category` | Pengelolaan transaksi |
| Economy News | `EconomyNewsController` | `economy-news.index` | - | Berita ekonomi RSS terkini dengan loading redirect |
| Documents | `DocumentController` | `documents.*` | `Document` | Upload dan preview file |
| Analytics | `AnalyticsController` | `analytics.index` | `FinanceRecord`, `Task` | Grafik tren |
| Profile | `ProfileController` | `profile.index` | `User` | Update profil, password, avatar |

## 8. Catatan Profesional
- Aplikasi dirancang untuk multi-user dengan otentikasi Laravel standar.
- Komponen avatar menggabungkan file lokal dan URL eksternal (Google) melalui helper `AvatarHelper`.
- Proses upload berbasis AJAX untuk pengalaman yang halus.
- Build asset Vite wajib agar view Blade dapat memuat `manifest.json`.

## 9. Rekomendasi untuk Developer Baru
1. Jalankan `composer install` dan `npm install`.
2. Salin `.env.example` jadi `.env` lalu `php artisan key:generate`.
3. Buat database, sesuaikan `.env`, lalu `php artisan migrate`.
4. Jalankan `php artisan storage:link`.
5. Jalankan `npm run build` sebelum membuka aplikasi di browser.
6. Untuk development, jalankan `npm run dev` dan `php artisan serve`.

---

Dokumen ini dirancang sebagai referensi cepat untuk developer yang ingin memahami bagaimana output Planova terhubung dengan kode dan proses internal yang terjadi di dalamnya.