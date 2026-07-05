# TODO - OptikCore (blackboxai)

## Status: In progress

### No.1 Konsistensi i18n Dashboard
- [x] Tambahkan key dashboard KPI ke lang/id/menu.php
- [x] Tambahkan key dashboard KPI ke lang/en/menu.php
- [x] Refactor label yang dipakai di resources/views/dashboard.blade.php
- [x] Validasi syntax php -l

### No.2 Konsistensi i18n Laporan Transaksi
- [x] Rapikan whitespace/indentasi struktur HTML di resources/views/laporan/index.blade.php (tanpa ubah logic)
- [ ] Update label hardcoded di resources/views/laporan/index.blade.php menjadi __('menu.xxx') (tombol export, print, filter, header tabel, empty state, footer)
- [ ] Tambahkan key menu.* yang belum ada ke lang/id/menu.php dan lang/en/menu.php
- [ ] Validasi syntax php -l
- [ ] Jalankan php artisan view:clear

### No.3 Lanjutan (setelah No.2 selesai)
- [ ] Laporan PDF/Print (optional): i18n untuk teks statis

