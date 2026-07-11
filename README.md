<div align="center">

# 🪴 Planova FOR THE DEVELOPER MD

### Satu workspace buat semua: tugas, catatan, keuangan, dokumen, dan analitik.

<p>
  <img src="https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
  <img src="https://img.shields.io/badge/PHP-%5E8.1-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/React-JSX-61DAFB?style=for-the-badge&logo=react&logoColor=white" alt="React">
</p>

<p>
  <img src="https://img.shields.io/badge/status-active--development-orange?style=flat-square" alt="Status">
  <img src="https://img.shields.io/badge/license-unlicensed-lightgrey?style=flat-square" alt="License">
</p>

[Fitur](#-fitur-utama) • [Tech Stack](#%EF%B8%8F-tech-stack) • [Instalasi](#-instalasi--menjalankan-lokal) • [Struktur](#-struktur-project) • [Roadmap](#-roadmap)

</div>

---

## 📖 Tentang

**Planova** adalah workspace produktivitas terinspirasi dari Notion — dibangun dari nol pakai Laravel. Daripada bolak-balik antara app to-do list, catatan, dan aplikasi keuangan yang beda-beda, Planova menyatukan semuanya jadi satu tempat yang rapi dan enak dipakai.

Dibangun dengan gaya visual **claymorphism** — soft shadow, rounded corner, dan palet warna teal & orange yang hangat — dilengkapi micro-interaction pakai Anime.js supaya interaksinya terasa hidup, bukan sekadar CRUD app biasa.

> 💡 Project ini juga jadi tempat eksperimen UI/UX pribadi — dari sistem grouped status property, custom task type, sampai block-based rich text editor ala Notion.

<!--
📸 Tempat buat screenshot / preview
Ganti bagian ini dengan GIF atau gambar dashboard, board view, dan notes editor supaya orang yang buka repo langsung kebayang tampilannya.

<div align="center">
  <img src="docs/preview-dashboard.png" width="800" alt="Planova Dashboard">
</div>
-->

## ✨ Fitur Utama

<table>
<tr>
<td width="50%" valign="top">

### 📋 Tasks
- Status `todo` → `in_progress` → `done` + prioritas & due date
- **Custom Task Properties** — bikin properti sendiri (select, dsb) mirip database property Notion
- **Board view** & **Table view** (React) — pindah tampilan sesuka hati
- **Command menu** (⌘K) buat navigasi cepat tanpa mouse
- Quick status update langsung dari list

### 📝 Notes
- **Block-based editor** — text, heading, bullet list, to-do, divider, table
- Tiap block bisa disusun ulang urutannya secara bebas
- Struktur block-nya polymorphic, reusable ke entity lain

</td>
<td width="50%" valign="top">

### 💰 Finance & Budget
- Catat pemasukan & pengeluaran per kategori
- Set budget bulanan/tahunan + progress pemakaian otomatis
- Ringkasan saldo bulan berjalan langsung di dashboard

### 📁 Documents
- Upload, simpan, dan download dokumen tanpa keluar workspace

### 📊 Analytics
- Grafik tren keuangan & task selesai 6 bulan terakhir (Chart.js)

### 🔐 Auth
- Login/register standar + **Login with Google** (Socialite)

</td>
</tr>
</table>

## 🛠️ Tech Stack

<table>
<tr><td><b>Backend</b></td><td>Laravel 10 · PHP ^8.1</td></tr>
<tr><td><b>Frontend</b></td><td>Blade · Tailwind CSS 3 · React (Board/Table view, Command Menu)</td></tr>
<tr><td><b>Auth</b></td><td>Laravel Sanctum · Laravel Socialite (Google OAuth)</td></tr>
<tr><td><b>Animasi</b></td><td>Anime.js</td></tr>
<tr><td><b>Chart</b></td><td>Chart.js</td></tr>
<tr><td><b>Build Tool</b></td><td>Vite</td></tr>
<tr><td><b>Testing</b></td><td>Pest</td></tr>
</table>

## 📂 Struktur Project

<details>
<summary>Klik untuk lihat struktur folder</summary>

```
app/
├─ Http/Controllers/       # Task, Note, Finance, Budget, Document, Analytics, Auth, dll
├─ Models/                 # Task, TaskProperty, TaskPropertyValue, Note, Block,
│                          # FinanceRecord, Budget, Category, Document, User
resources/
├─ views/                  # Blade views per modul (tasks, notes, finance, budget, documents, analytics, dashboard)
├─ js/react/                # Board & Table view, Command Menu (React)
├─ css/                     # Styling claymorphism (app.css, landing.css)
database/
└─ migrations/              # Skema tabel tasks, notes, blocks, finance, budget, documents, task_properties, dst
```

</details>

## 🚀 Instalasi & Menjalankan Lokal

**Requirement:** PHP ^8.1 · Composer · Node.js · MySQL (atau database lain yang didukung Laravel)

```bash
# 1. Clone repo
git clone https://github.com/Fahmiemambo/Planova.git
cd Planova

# 2. Install dependency
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Setup database (buat database "planova" atau sesuaikan .env)
php artisan migrate

# 5. Jalankan
php artisan serve
npm run dev
```

Buka **http://localhost:8000** 🎉

<details>
<summary>⚙️ Opsional: Login with Google</summary>

<br>

Isi kredensial berikut di `.env`:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

</details>

## 🗺️ Roadmap

- [ ] UI/UX rebuild untuk konsistensi desain di semua halaman
- [ ] Penyempurnaan sistem Task Properties (grouped status) & Task Types
- [ ] Rich text toolbar untuk block editor di Notes
- [ ] Dark mode penuh di seluruh halaman

## 🤝 Kontribusi

Planova masih dikembangkan secara individu untuk keperluan belajar & eksperimen UI/UX. Saran, ide, atau bug report tetap terbuka lewat **Issues**.

## 📄 Lisensi

Belum ditentukan secara resmi — tambahkan file `LICENSE` sebelum dipakai secara publik.

---

<div align="center">
  <sub>Dibangun dengan Laravel, secangkir kopi, dan terlalu banyak refactor UI 🌿</sub>
</div>
