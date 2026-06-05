<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan  = $request->bulan  ?? Carbon::now()->month;
        $tahun  = $request->tahun  ?? Carbon::now()->year;
        $status = $request->status ?? '';

        $query = Transaksi::with(['pelanggan', 'details.produk'])
                    ->whereMonth('tanggal_transaksi', $bulan)
                    ->whereYear('tanggal_transaksi', $tahun);

        if ($status !== '') {
            $query->where('status', $status);
        }

        $transaksis      = $query->orderBy('tanggal_transaksi', 'desc')->get();
        $totalPendapatan = $transaksis->where('status', 'selesai')->sum('total_harga');

        $daftarBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember'
        ];

        return view('laporan.index', compact(
            'transaksis', 'totalPendapatan',
            'bulan', 'tahun', 'status', 'daftarBulan'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan  = $request->bulan ?? Carbon::now()->month;
        $tahun  = $request->tahun ?? Carbon::now()->year;

        $transaksis = Transaksi::with(['pelanggan', 'details.produk'])
                        ->whereMonth('tanggal_transaksi', $bulan)
                        ->whereYear('tanggal_transaksi', $tahun)
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        $totalPendapatan = $transaksis->where('status', 'selesai')->sum('total_harga');

        $daftarBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember'
        ];

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'transaksis', 'totalPendapatan', 'bulan', 'tahun', 'daftarBulan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-' . $daftarBulan[$bulan] . '-' . $tahun . '.pdf');
    }

    public function exportCsv(Request $request)
    {
        $bulan  = $request->bulan ?? Carbon::now()->month;
        $tahun  = $request->tahun ?? Carbon::now()->year;

        $transaksis = Transaksi::with(['pelanggan', 'details.produk'])
                        ->whereMonth('tanggal_transaksi', $bulan)
                        ->whereYear('tanggal_transaksi', $tahun)
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        $daftarBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember'
        ];

        $filename = 'laporan-' . $daftarBulan[$bulan] . '-' . $tahun . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transaksis) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'No', 'Kode Transaksi', 'Pelanggan',
                'Produk', 'Total Harga', 'Metode Bayar',
                'Tanggal', 'Status'
            ]);

            foreach ($transaksis as $i => $t) {
                $produkList = $t->details->map(function ($d) {
                    return $d->produk->nama_produk . ' (' . $d->jumlah . 'x)';
                })->join(', ');

                fputcsv($file, [
                    $i + 1,
                    $t->kode_transaksi,
                    $t->pelanggan->nama,
                    $produkList,
                    $t->total_harga,
                    ucfirst($t->metode_bayar),
                    Carbon::parse($t->tanggal_transaksi)->format('d/m/Y'),
                    ucfirst($t->status),
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, [
                '', '', '', 'TOTAL PENDAPATAN',
                $transaksis->where('status', 'selesai')->sum('total_harga'),
                '', '', ''
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}