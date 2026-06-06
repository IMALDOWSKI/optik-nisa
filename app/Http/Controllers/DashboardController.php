<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Hari Ini
        $transaksiHariIni  = Transaksi::whereDate('tanggal_transaksi', Carbon::today())->count();
        $pendapatanHariIni = Transaksi::whereDate('tanggal_transaksi', Carbon::today())
                                ->where('status', 'selesai')
                                ->sum('total_harga');

        // Statistik Bulan Ini
        $transaksBulanIni   = Transaksi::whereMonth('tanggal_transaksi', Carbon::now()->month)
                                ->whereYear('tanggal_transaksi', Carbon::now()->year)
                                ->count();
        $pendapatanBulanIni = Transaksi::whereMonth('tanggal_transaksi', Carbon::now()->month)
                                ->whereYear('tanggal_transaksi', Carbon::now()->year)
                                ->where('status', 'selesai')
                                ->sum('total_harga');

        // Total Keseluruhan
        $totalPelanggan = Pelanggan::count();
        $totalProduk    = Produk::count();

        // Stok Menipis (stok <= 5)
        $stokMenipis = Produk::where('stok', '<=', 5)
                        ->where('status', 'aktif')
                        ->orderBy('stok')
                        ->get();

        // Grafik Pendapatan 6 Bulan Terakhir
        $grafikData  = [];
        $grafikLabel = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan          = Carbon::now()->subMonths($i);
            $grafikLabel[]  = $bulan->format('M Y');
            $grafikData[]   = Transaksi::whereMonth('tanggal_transaksi', $bulan->month)
                                ->whereYear('tanggal_transaksi', $bulan->year)
                                ->where('status', 'selesai')
                                ->sum('total_harga');
        }

        // Transaksi Terbaru
        $transaksiTerbaru = Transaksi::with('pelanggan')
                                ->latest()
                                ->take(7)
                                ->get();

        // Produk Terlaris
        $produkTerlaris = DB::table('detail_transaksis')
                            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                            ->select(
                                'produks.nama_produk',
                                DB::raw('SUM(detail_transaksis.jumlah) as total_terjual')
                            )
                            ->groupBy('produks.id', 'produks.nama_produk')
                            ->orderByDesc('total_terjual')
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksBulanIni',
            'pendapatanBulanIni',
            'totalPelanggan',
            'totalProduk',
            'stokMenipis',
            'grafikData',
            'grafikLabel',
            'transaksiTerbaru',
            'produkTerlaris'
        ));
    }
}