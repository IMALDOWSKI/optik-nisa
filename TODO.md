UI/UX# TODO - OptikCore (blackboxai)

## Status: In progress

### No.1 Konsistensi i18n Dashboard
- [x] Tambahkan key dashboard KPI ke lang/id/menu.php
- [x] Tambahkan key dashboard KPI ke lang/en/menu.php
- [x] Refactor label yang dipakai di resources/views/dashboard.blade.php
- [x] Validasi syntax php -l

### No.2 Konsistensi i18n Laporan Transaksi
- [x] Rapikan whitespace/indentasi struktur HTML di resources/views/laporan/index.blade.php (tanpa ubah logic)
- [x] Update label hardcoded di resources/views/laporan/index.blade.php menjadi __('menu.xxx') (tombol export, print, filter, header tabel, empty state, footer)
- [x] Tambahkan key menu.* yang dibutuhkan ke lang/id/menu.php dan lang/en/menu.php
- [x] Validasi syntax php -l
- [x] Jalankan php artisan view:clear

### No.3 Lanjutan (setelah No.2 selesai)
- [x] i18n untuk teks statis export PDF/Print (resources/views/laporan/pdf.blade.php)
- [x] Validasi syntax php -l
- [x] Jalankan php artisan view:clear

### No.4 Lanjutan (setelah No.3 selesai)
- [ ] Rapikan hardcoded label sisa di resources/views/laporan/pdf.blade.php menjadi menu.* keys
- [ ] Tambahkan key yang belum ada di lang/id/menu.php & lang/en/menu.php
- [ ] Validasi syntax php -l & Jalankan php artisan view:clear
- [ ] Commit + push

