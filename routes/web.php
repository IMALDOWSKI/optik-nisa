<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResepMataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {

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
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.csv');
    });

});

require __DIR__.'/auth.php';