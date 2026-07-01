<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ===== LAPORAN TRANSAKSI =====
    public function index(Request $request)
    {
        $bulan  = $request->bulan  ?? Carbon::now()->month;
        $tahun  = $request->tahun  ?? Carbon::now()->year;
        $status = $request->status ?? '';

        $query = Transaksi::with(['pelanggan', 'details.produk', 'user'])
                    ->whereMonth('tanggal_transaksi', $bulan)
                    ->whereYear('tanggal_transaksi', $tahun);

        if ($status !== '') {
            $query->where('status', $status);
        }

        $transaksis      = $query->orderBy('tanggal_transaksi', 'desc')->get();
        $totalPendapatan = $transaksis->where('status', 'selesai')->sum('grand_total');
        $totalDiskon     = $transaksis->where('status', 'selesai')->sum('diskon');
        $totalTransaksi  = $transaksis->count();

        $daftarBulan = $this->daftarBulan();

        return view('laporan.index', compact(
            'transaksis', 'totalPendapatan', 'totalDiskon',
            'totalTransaksi', 'bulan', 'tahun', 'status', 'daftarBulan'
        ));
    }

    // ===== LAPORAN PER KATEGORI =====
    public function kategori(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $data = DB::table('detail_transaksis')
                    ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                    ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                    ->where('transaksis.status', 'selesai')
                    ->whereMonth('transaksis.tanggal_transaksi', $bulan)
                    ->whereYear('transaksis.tanggal_transaksi', $tahun)
                    ->select(
                        'produks.kategori',
                        DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'),
                        DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan'),
                        DB::raw('COUNT(DISTINCT transaksis.id) as total_transaksi')
                    )
                    ->groupBy('produks.kategori')
                    ->orderByDesc('total_pendapatan')
                    ->get();

        // Detail per produk
        $detailProduk = DB::table('detail_transaksis')
                    ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                    ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                    ->where('transaksis.status', 'selesai')
                    ->whereMonth('transaksis.tanggal_transaksi', $bulan)
                    ->whereYear('transaksis.tanggal_transaksi', $tahun)
                    ->select(
                        'produks.nama_produk',
                        'produks.kategori',
                        'produks.kode_produk',
                        DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'),
                        DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan')
                    )
                    ->groupBy('produks.id', 'produks.nama_produk', 'produks.kategori', 'produks.kode_produk')
                    ->orderByDesc('total_pendapatan')
                    ->get();

        $daftarBulan = $this->daftarBulan();

        return view('laporan.kategori', compact(
            'data', 'detailProduk', 'bulan', 'tahun', 'daftarBulan'
        ));
    }

    // ===== LAPORAN PER KASIR =====
    public function kasir(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $dataKasir = Transaksi::with('user')
                        ->where('status', 'selesai')
                        ->whereMonth('tanggal_transaksi', $bulan)
                        ->whereYear('tanggal_transaksi', $tahun)
                        ->select(
                            'user_id',
                            DB::raw('COUNT(*) as total_transaksi'),
                            DB::raw('SUM(grand_total) as total_pendapatan'),
                            DB::raw('SUM(diskon) as total_diskon'),
                            DB::raw('AVG(grand_total) as rata_rata')
                        )
                        ->groupBy('user_id')
                        ->get();

        $daftarBulan = $this->daftarBulan();

        return view('laporan.kasir', compact(
            'dataKasir', 'bulan', 'tahun', 'daftarBulan'
        ));
    }

    // ===== LAPORAN KEUANGAN =====
    public function keuangan(Request $request)
    {
        $tahun = $request->tahun ?? Carbon::now()->year;

        // Pendapatan per bulan
        $pendapatanPerBulan = [];
        $daftarBulan = $this->daftarBulan();

        foreach ($daftarBulan as $num => $nama) {
            $pendapatanPerBulan[$nama] = Transaksi::where('status', 'selesai')
                ->whereMonth('tanggal_transaksi', $num)
                ->whereYear('tanggal_transaksi', $tahun)
                ->sum('grand_total');
        }

        $totalTahunIni  = array_sum($pendapatanPerBulan);
        $totalDiskon    = Transaksi::where('status', 'selesai')
                            ->whereYear('tanggal_transaksi', $tahun)
                            ->sum('diskon');
        $totalTransaksi = Transaksi::where('status', 'selesai')
                            ->whereYear('tanggal_transaksi', $tahun)
                            ->count();

        return view('laporan.keuangan', compact(
            'pendapatanPerBulan', 'totalTahunIni',
            'totalDiskon', 'totalTransaksi', 'tahun', 'daftarBulan'
        ));
    }

    // ===== EXPORT PDF =====
    public function exportPdf(Request $request)
    {
        $bulan  = $request->bulan ?? Carbon::now()->month;
        $tahun  = $request->tahun ?? Carbon::now()->year;

        $transaksis = Transaksi::with(['pelanggan', 'details.produk'])
                        ->whereMonth('tanggal_transaksi', $bulan)
                        ->whereYear('tanggal_transaksi', $tahun)
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        $totalPendapatan = $transaksis->where('status', 'selesai')->sum('grand_total');
        $daftarBulan     = $this->daftarBulan();

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'transaksis', 'totalPendapatan', 'bulan', 'tahun', 'daftarBulan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-' . $daftarBulan[$bulan] . '-' . $tahun . '.pdf');
    }

    // ===== EXPORT CSV =====
    public function exportCsv(Request $request)
    {
        $bulan  = $request->bulan ?? Carbon::now()->month;
        $tahun  = $request->tahun ?? Carbon::now()->year;

        $transaksis  = Transaksi::with(['pelanggan', 'details.produk'])
                        ->whereMonth('tanggal_transaksi', $bulan)
                        ->whereYear('tanggal_transaksi', $tahun)
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        $daftarBulan = $this->daftarBulan();
        $filename    = 'laporan-' . $daftarBulan[$bulan] . '-' . $tahun . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transaksis) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'No', 'Kode Transaksi', 'Pelanggan',
                'Produk', 'Subtotal', 'Diskon', 'Grand Total',
                'Metode Bayar', 'Tanggal', 'Status'
            ]);

            foreach ($transaksis as $i => $t) {
                $produkList = $t->details->map(function ($d) {
    $nama = $d->is_frame_sendiri
        ? 'Frame Milik Pelanggan' . ($d->keterangan_frame_sendiri ? ' ('.$d->keterangan_frame_sendiri.')' : '')
        : ($d->produk->nama_produk ?? '-');
    return $nama . ' (' . $d->jumlah . 'x)';
})->join(', ');

                fputcsv($file, [
                    $i + 1,
                    $t->kode_transaksi,
                    $t->pelanggan->nama,
                    $produkList,
                    $t->total_harga,
                    $t->diskon,
                    $t->grand_total,
                    ucfirst($t->metode_bayar),
                    Carbon::parse($t->tanggal_transaksi)->format('d/m/Y'),
                    ucfirst($t->status),
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, [
                '', '', '', '', 'TOTAL PENDAPATAN',
                '', $transaksis->where('status', 'selesai')->sum('grand_total'),
                '', '', ''
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ===== PRINT VIEW (Browser Print) =====
public function printView(Request $request)
{
    $bulan  = $request->bulan ?? Carbon::now()->month;
    $tahun  = $request->tahun ?? Carbon::now()->year;
    $status = $request->status ?? '';

    $query = Transaksi::with(['pelanggan', 'details.produk', 'user'])
                ->whereMonth('tanggal_transaksi', $bulan)
                ->whereYear('tanggal_transaksi', $tahun);

    if ($status !== '') {
        $query->where('status', $status);
    }

    $transaksis      = $query->orderBy('tanggal_transaksi', 'desc')->get();
    $totalPendapatan = $transaksis->where('status', 'selesai')->sum('grand_total');
    $totalDiskon     = $transaksis->where('status', 'selesai')->sum('diskon');
    $daftarBulan     = $this->daftarBulan();

    return view('laporan.print', compact(
        'transaksis', 'totalPendapatan', 'totalDiskon', 'bulan', 'tahun', 'daftarBulan'
    ));
}

    // ===== HELPER =====
    private function daftarBulan()
    {
        return [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember'
        ];
    }
}