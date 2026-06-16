# 👓 Optik Nisa — Sistem Manajemen Optik

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Status-Active%20Development-success?style=for-the-badge" alt="Status">
</p>

Sistem manajemen toko optik berbasis web yang dibangun untuk membantu operasional optik sehari-hari — mulai dari transaksi penjualan, manajemen stok, resep mata, hingga laporan keuangan. Project ini berawal dari studi kasus mata kuliah **System Design Analyst** yang dikembangkan lebih jauh menjadi aplikasi siap pakai berdasarkan pengalaman nyata bekerja di sebuah optik.

---

## 🌐 Live Demo

Coba langsung sistemnya di sini:

**🔗 [https://web-production-1c9b1a.up.railway.app](https://web-production-1c9b1a.up.railway.app)**

**Kredensial Login (Demo):**
Email    : admin@optiknisa.com

Password : admin123

> ⚠️ **Catatan:** Ini adalah environment demo dengan data dummy. Data dapat berubah sewaktu-waktu karena digunakan untuk keperluan testing dan presentasi.

---

## 📸 Screenshot

### Login Page
*(Tambahkan screenshot login page di sini)*

### Dashboard
*(Tambahkan screenshot dashboard di sini)*

### Data Produk
*(Tambahkan screenshot halaman produk di sini)*

### Detail Transaksi
*(Tambahkan screenshot detail transaksi di sini)*

---

## ✨ Fitur Utama

### 🛒 Operasional Inti
- Manajemen produk (kacamata, lensa, aksesoris) dengan kategori dan atribut spesifik
- Transaksi multi-produk dengan dukungan diskon (nominal/persen) dan pembayaran DP/cicil
- Cetak struk transaksi otomatis (PDF, format thermal 80mm)
- Manajemen pelanggan beserta riwayat transaksi dan resep mata
- Pencatatan resep mata (OD/OS, sph/cyl/axis, PD)
- Restok produk & manajemen supplier
- Garansi produk dengan tracking status dan masa berlaku

### 💰 Keuangan
- Pencatatan hutang pelanggan (sistem DP/cicil) dengan riwayat pembayaran
- Pencatatan pengeluaran operasional toko per kategori
- Laporan laba rugi otomatis (pendapatan − modal − pengeluaran)
- Laporan transaksi, kategori, kasir, dan keuangan (export PDF/CSV)
- Sistem kartu member dengan poin reward

### 📦 Manajemen Operasional
- Tracking status pesanan kacamata (menunggu → diproses → siap diambil)
- Jadwal & booking (kontrol mata, ambil kacamata, konsultasi)
- Antrian digital dengan tampilan display untuk TV/monitor toko
- Reminder otomatis untuk pelanggan yang perlu kontrol mata
- Notifikasi stok menipis dan aktivitas penting lainnya
- Pencatatan barcode produk dan cetak label barcode (single & massal)

### 🔐 Keamanan & Administrasi
- Autentikasi berbasis role (Admin & Kasir)
- Activity log — pencatatan seluruh aktivitas pengguna dalam sistem
- Backup database manual (export SQL langsung dari browser)
- Manajemen pengguna (multi-kasir)

### 🌍 Pengalaman Pengguna
- Mode gelap (dark mode)
- Multi-bahasa (Indonesia & English)
- Tampilan responsif untuk perangkat mobile
- Integrasi WhatsApp untuk kirim struk, reminder, dan update status pesanan
- Dashboard interaktif dengan grafik analitik penjualan

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|---|---|
| Backend | Laravel 13, PHP 8.3 |
| Database | MySQL |
| Frontend | Blade Templating, Bootstrap (SB Admin 2), Chart.js |
| PDF Generator | barryvdh/laravel-dompdf |
| Barcode | JsBarcode |
| Deployment | Railway |
| Version Control | Git & GitHub |

---

## 🚀 Instalasi Lokal

```bash
# Clone repository
git clone https://github.com/IMALDOWSKI/optik-nisa.git
cd optik-nisa

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di file .env, lalu jalankan migrasi
php artisan migrate
php artisan db:seed

# Jalankan storage link untuk upload file
php artisan storage:link

# Build asset frontend
npm run build

# Jalankan server lokal
php artisan serve
```

Akses aplikasi di `http://127.0.0.1:8000`

---

## 📋 Latar Belakang Project

Project ini bermula dari pengalaman langsung bekerja di sebuah optik, di mana banyak proses operasional (pencatatan transaksi, stok, hingga resep mata pelanggan) masih dilakukan secara manual. Studi kasus ini kemudian diangkat sebagai tugas analisis pada mata kuliah **System Design Analyst** di semester 3, dan dikembangkan lebih jauh menjadi sebuah sistem yang siap untuk diimplementasikan secara nyata.

Tujuan project:
- Membantu digitalisasi operasional toko optik tempat penulis pernah bekerja
- Portofolio pengembangan sistem dari tahap analisis hingga deployment
- Sarana pembelajaran pengembangan full-stack berbasis Laravel

---

## 📌 Status Pengembangan

🚧 **Project ini masih dalam pengembangan aktif.** Beberapa fitur lanjutan seperti integrasi payment gateway resmi (QRIS via Midtrans/Xendit), aplikasi mobile pendamping, dan fitur multi-cabang sedang dalam tahap perencanaan.

---

## 👨‍💻 Developer

**IMALDOWSKI**

- 📧 Email: [hikmal393@gmail.com](mailto:hikmal393@gmail.com)
- 💬 WhatsApp: [+62 821-7973-6557](https://wa.me/6282179736557)
- 🐙 GitHub: [@IMALDOWSKI](https://github.com/IMALDOWSKI)

---

<p align="center">Made with ❤️ for Optik Nisa</p>


