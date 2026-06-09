<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Restok;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        // Pendapatan
        $totalPendapatan = Transaksi::where('status', 'selesai')
                            ->whereMonth('tanggal_transaksi', $bulan)
                            ->whereYear('tanggal_transaksi', $tahun)
                            ->sum('grand_total');

        $totalDiskon = Transaksi::where('status', 'selesai')
                            ->whereMonth('tanggal_transaksi', $bulan)
                            ->whereYear('tanggal_transaksi', $tahun)
                            ->sum('diskon');

        // Pengeluaran operasional
        $totalPengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->sum('jumlah');

        // Modal (harga beli restok)
        $totalModal = Restok::whereMonth('tanggal_restok', $bulan)
                        ->whereYear('tanggal_restok', $tahun)
                        ->whereNotNull('harga_beli')
                        ->selectRaw('SUM(harga_beli * jumlah_tambah) as total')
                        ->value('total') ?? 0;

        // Laba Kotor = Pendapatan - Modal
        $labaKotor = $totalPendapatan - $totalModal;

        // Laba Bersih = Laba Kotor - Pengeluaran
        $labaBersih = $labaKotor - $totalPengeluaran;

        // Detail pengeluaran per kategori
        $pengeluaranPerKategori = Pengeluaran::whereMonth('tanggal', $bulan)
                                    ->whereYear('tanggal', $tahun)
                                    ->selectRaw('kategori, SUM(jumlah) as total')
                                    ->groupBy('kategori')
                                    ->get();

        // Data 6 bulan untuk grafik
        $grafikLabel    = [];
        $grafikPendapatan = [];
        $grafikPengeluaran = [];
        $grafikLaba     = [];

        for ($i = 5; $i >= 0; $i--) {
            $b = Carbon::now()->subMonths($i);
            $grafikLabel[] = $b->format('M Y');

            $pend = Transaksi::where('status', 'selesai')
                        ->whereMonth('tanggal_transaksi', $b->month)
                        ->whereYear('tanggal_transaksi', $b->year)
                        ->sum('grand_total');

            $peng = Pengeluaran::whereMonth('tanggal', $b->month)
                        ->whereYear('tanggal', $b->year)
                        ->sum('jumlah');

            $grafikPendapatan[]  = $pend;
            $grafikPengeluaran[] = $peng;
            $grafikLaba[]        = $pend - $peng;
        }

        $daftarBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember'
        ];

        return view('laba_rugi.index', compact(
            'totalPendapatan', 'totalDiskon', 'totalModal',
            'totalPengeluaran', 'labaKotor', 'labaBersih',
            'pengeluaranPerKategori', 'bulan', 'tahun', 'daftarBulan',
            'grafikLabel', 'grafikPendapatan', 'grafikPengeluaran', 'grafikLaba'
        ));
    }
}