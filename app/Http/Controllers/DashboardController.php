<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Restok;
use App\Models\Garansi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== STATISTIK HARI INI =====
        $transaksiHariIni  = Transaksi::whereDate('tanggal_transaksi', Carbon::today())->count();
        $pendapatanHariIni = Transaksi::whereDate('tanggal_transaksi', Carbon::today())
                                ->where('status', 'selesai')->sum('grand_total');

        // ===== STATISTIK BULAN INI =====
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $transaksBulanIni   = Transaksi::whereMonth('tanggal_transaksi', $bulanIni)
                                ->whereYear('tanggal_transaksi', $tahunIni)->count();
        $pendapatanBulanIni = Transaksi::whereMonth('tanggal_transaksi', $bulanIni)
                                ->whereYear('tanggal_transaksi', $tahunIni)
                                ->where('status', 'selesai')->sum('grand_total');

        // ===== TOTAL KESELURUHAN =====
        $totalPelanggan  = Pelanggan::count();
        $totalProduk     = Produk::count();
        $totalPendapatan = Transaksi::where('status', 'selesai')->sum('grand_total');
        $totalDiskon     = Transaksi::where('status', 'selesai')->sum('diskon');

        // ===== STOK MENIPIS =====
        $stokMenipis = Produk::where('stok', '<=', 5)
                        ->where('status', 'aktif')
                        ->orderBy('stok')
                        ->get();

        // ===== GARANSI HAMPIR EXPIRED =====
        $garansiHampirExpired = Garansi::where('status', 'aktif')
                                    ->where('tanggal_selesai', '<=', Carbon::now()->addDays(7))
                                    ->with('pelanggan', 'produk')
                                    ->get();

        // ===== GRAFIK PENDAPATAN 6 BULAN =====
        $grafikData  = [];
        $grafikLabel = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan         = Carbon::now()->subMonths($i);
            $grafikLabel[] = $bulan->format('M Y');
            $grafikData[]  = Transaksi::whereMonth('tanggal_transaksi', $bulan->month)
                                ->whereYear('tanggal_transaksi', $bulan->year)
                                ->where('status', 'selesai')
                                ->sum('grand_total');
        }

        // ===== GRAFIK TRANSAKSI PER METODE BAYAR =====
        $metodeBayarData = Transaksi::where('status', 'selesai')
                            ->whereMonth('tanggal_transaksi', $bulanIni)
                            ->whereYear('tanggal_transaksi', $tahunIni)
                            ->select('metode_bayar', DB::raw('count(*) as total'))
                            ->groupBy('metode_bayar')
                            ->get();

        // ===== GRAFIK PENJUALAN PER KATEGORI =====
        $kategoriData = DB::table('detail_transaksis')
                            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                            ->where('transaksis.status', 'selesai')
                            ->whereMonth('transaksis.tanggal_transaksi', $bulanIni)
                            ->whereYear('transaksis.tanggal_transaksi', $tahunIni)
                            ->select('produks.kategori', DB::raw('SUM(detail_transaksis.jumlah) as total'))
                            ->groupBy('produks.kategori')
                            ->get();

        // ===== PRODUK TERLARIS =====
        $produkTerlaris = DB::table('detail_transaksis')
                            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                            ->where('transaksis.status', 'selesai')
                            ->select(
                                'produks.nama_produk',
                                'produks.kategori',
                                DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'),
                                DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan')
                            )
                            ->groupBy('produks.id', 'produks.nama_produk', 'produks.kategori')
                            ->orderByDesc('total_terjual')
                            ->take(5)
                            ->get();

        // ===== TRANSAKSI TERBARU =====
        $transaksiTerbaru = Transaksi::with('pelanggan')
                                ->latest()->take(7)->get();

        // ===== PELANGGAN BARU BULAN INI =====
        $pelangganBaru = Pelanggan::whereMonth('created_at', $bulanIni)
                            ->whereYear('created_at', $tahunIni)
                            ->count();

        return view('dashboard', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksBulanIni',
            'pendapatanBulanIni',
            'totalPelanggan',
            'totalProduk',
            'totalPendapatan',
            'totalDiskon',
            'stokMenipis',
            'garansiHampirExpired',
            'grafikData',
            'grafikLabel',
            'metodeBayarData',
            'kategoriData',
            'produkTerlaris',
            'transaksiTerbaru',
            'pelangganBaru'
        ));
    }
}