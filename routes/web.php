<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResepMataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Semua route dilindungi login
Route::middleware(['auth'])->group(function () {

    // Dashboard - semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  
    Route::post('/pelanggan/ajax-store', [PelangganController::class, 'ajaxStore'])->name('pelanggan.ajax-store');

    // Pelanggan, Produk, Transaksi, Resep Mata - semua role bisa akses
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('resep', ResepMataController::class);

    // Khusus Admin saja
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::get('/laporan', function () {
            return view('laporan.index');
        })->name('laporan.index');
    });

});

require __DIR__.'/auth.php';