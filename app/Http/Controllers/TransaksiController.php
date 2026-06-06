<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('pelanggan')->latest()->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $produks    = Produk::where('status', 'aktif')->where('stok', '>', 0)->get();
        return view('transaksi.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggans,id',
            'tanggal_transaksi' => 'required|date',
            'metode_bayar'      => 'required',
            'produk_id'         => 'required|array|min:1',
            'produk_id.*'       => 'required|exists:produks,id',
            'jumlah'            => 'required|array|min:1',
            'jumlah.*'          => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;

            foreach ($request->produk_id as $i => $produkId) {
                $produk = Produk::find($produkId);
                $jumlah = $request->jumlah[$i];
                $total += $produk->harga * $jumlah;
            }

            $bayar     = $request->bayar ?? $total;
            $kembalian = $bayar - $total;

            $transaksi = Transaksi::create([
                'kode_transaksi'    => Transaksi::generateKode(),
                'pelanggan_id'      => $request->pelanggan_id,
                'total_harga'       => $total,
                'metode_bayar'      => $request->metode_bayar,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status'            => 'selesai',
                'catatan'           => $request->catatan,
            ]);

            foreach ($request->produk_id as $i => $produkId) {
                $produk   = Produk::find($produkId);
                $jumlah   = $request->jumlah[$i];
                $subtotal = $produk->harga * $jumlah;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $produkId,
                    'jumlah'       => $jumlah,
                    'harga_satuan' => $produk->harga,
                    'subtotal'     => $subtotal,
                ]);

                $produk->decrement('stok', $jumlah);
            }
        });

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'details.produk']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function struk(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'details.produk']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transaksi.struk', compact('transaksi'))
                ->setPaper([0, 0, 226.77, 500], 'portrait');

        return $pdf->stream('struk-' . $transaksi->kode_transaksi . '.pdf');
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            foreach ($transaksi->details as $detail) {
                $detail->produk->increment('stok', $detail->jumlah);
            }
            $transaksi->delete();
        });

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil dihapus!');
    }
}