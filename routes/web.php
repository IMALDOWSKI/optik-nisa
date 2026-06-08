<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResepMataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\RestokController;
use App\Http\Controllers\GaransiController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('pesanan', PesananController::class)->only(['index', 'create', 'store', 'show']);
Route::post('/pesanan/{pesanan}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    Route::resource('hutang', HutangController::class)->only(['index', 'show']);
Route::post('/hutang/{hutang}/bayar', [HutangController::class, 'bayar'])->name('hutang.bayar');
    Route::resource('supplier', SupplierController::class);
    Route::resource('garansi', GaransiController::class)->only(['index', 'create', 'store', 'show']);
Route::post('/garansi/{garansi}/klaim', [GaransiController::class, 'klaim'])->name('garansi.klaim');
    Route::resource('restok', RestokController::class)->only(['index', 'create', 'store', 'show']);
    
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{notifikasi}/baca', [NotifikasiController::class, 'tandaiBaca'])->name('notifikasi.baca');
    Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'tandaiSemuaBaca'])->name('notifikasi.baca-semua');
    Route::delete('/notifikasi/{notifikasi}/hapus', [NotifikasiController::class, 'hapus'])->name('notifikasi.hapus');
    Route::delete('/notifikasi/hapus-semua', [NotifikasiController::class, 'hapusSemua'])->name('notifikasi.hapus-semua');
    

    Route::get('/pelanggan/{pelanggan}/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pelanggan', PelangganController::class);
    Route::post('/pelanggan/ajax-store', [PelangganController::class, 'ajaxStore'])->name('pelanggan.ajax-store');

    Route::resource('produk', ProdukController::class);

    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/{transaksi}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');

    Route::resource('resep', ResepMataController::class);

Route::middleware(['role:admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/kategori', [LaporanController::class, 'kategori'])->name('laporan.kategori');
    Route::get('/laporan/kasir', [LaporanController::class, 'kasir'])->name('laporan.kasir');
    Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.csv');
});

});

require __DIR__.'/auth.php';
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/ganti-password', [ProfileController::class, 'gantiPassword'])->name('profile.ganti-password');