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
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/cetak-barcode-produk/{produk}', [ProdukController::class, 'cetakBarcode'])->name('cetak.barcode.produk');

    Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');
    // Display antrian - bisa diakses tanpa login (untuk TV/monitor toko)
Route::get('/antrian/display', [AntrianController::class, 'display'])->name('antrian.display');
Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');
Route::post('/antrian', [AntrianController::class, 'store'])->name('antrian.store');
Route::post('/antrian/{antrian}/panggil', [AntrianController::class, 'panggil'])->name('antrian.panggil');
Route::post('/antrian/{antrian}/selesai', [AntrianController::class, 'selesai'])->name('antrian.selesai');
Route::post('/antrian/{antrian}/batal', [AntrianController::class, 'batal'])->name('antrian.batal');
Route::delete('/antrian/reset', [AntrianController::class, 'reset'])->name('antrian.reset');

    Route::resource('jadwal', JadwalController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
Route::post('/jadwal/{jadwal}/update-status', [JadwalController::class, 'updateStatus'])->name('jadwal.update-status');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
Route::delete('/pengaturan/qris/hapus', [PengaturanController::class, 'hapusQris'])->name('pengaturan.qris.hapus');
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('/backup/buat', [BackupController::class, 'buat'])->name('backup.buat');
Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
Route::delete('/backup/hapus', [BackupController::class, 'hapus'])->name('backup.hapus');
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
Route::get('/activity-log/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-log.show');
Route::delete('/activity-log/hapus-lama', [ActivityLogController::class, 'hapusLama'])->name('activity-log.hapus-lama');
    Route::resource('member', MemberController::class)->only(['index', 'create', 'store', 'show']);
Route::post('/member/{member}/tukar-poin', [MemberController::class, 'tukarPoin'])->name('member.tukar-poin');
    Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
    Route::resource('pengeluaran', PengeluaranController::class)
     ->only(['index', 'create', 'store', 'destroy']);
Route::get('/laba-rugi', [LabaRugiController::class, 'index'])->name('laba-rugi.index');
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

    Route::get('/produk/barcode/cetak-massal', [ProdukController::class, 'cetakBarcodeMassal'])->name('produk.barcode.massal');

Route::resource('produk', ProdukController::class);

    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/{transaksi}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');

    Route::resource('resep', ResepMataController::class);

    Route::get('/api/produk/barcode/{barcode}', function($barcode) {
    $produk = \App\Models\Produk::where('barcode', $barcode)
                ->orWhere('kode_produk', $barcode)
                ->where('status', 'aktif')
                ->where('stok', '>', 0)
                ->first();

    if (!$produk) {
        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }

    return response()->json([
        'id'          => $produk->id,
        'nama_produk' => $produk->nama_produk,
        'harga'       => $produk->harga,
        'stok'        => $produk->stok,
        'kategori'    => $produk->kategori,
        'kode_produk' => $produk->kode_produk,
    ]);
})->name('api.produk.barcode');

Route::middleware(['role:admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/kategori', [LaporanController::class, 'kategori'])->name('laporan.kategori');
    Route::get('/laporan/kasir', [LaporanController::class, 'kasir'])->name('laporan.kasir');
    Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.csv');
    Route::get('/laporan/print', [LaporanController::class, 'printView'])->name('laporan.print');
});

});

require __DIR__.'/auth.php';
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/ganti-password', [ProfileController::class, 'gantiPassword'])->name('profile.ganti-password');