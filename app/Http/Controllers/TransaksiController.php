<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\PoinRiwayat;
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
        // Jika DP / belum lunas
if ($request->tipe_bayar == 'dp') {
    $dp          = $request->dp ?? 0;
    $sisaHutang  = $grandTotal - $dp;

    Hutang::create([
        'pelanggan_id'  => $request->pelanggan_id,
        'transaksi_id'  => $transaksi->id,
        'user_id'       => auth()->id(),
        'total_tagihan' => $grandTotal,
        'total_bayar'   => $dp,
        'sisa_hutang'   => $sisaHutang,
        'status'        => $sisaHutang <= 0 ? 'lunas' : 'belum_lunas',
        'jatuh_tempo'   => $request->jatuh_tempo,
        'catatan'       => $request->catatan,
    ]);
}
    }

public function store(Request $request)
{
    
    $request->validate([
        'pelanggan_id'      => 'required|exists:pelanggans,id',
        'tanggal_transaksi' => 'required|date',
        'metode_bayar'      => 'required',
        'tipe_bayar'        => 'required',
        'produk_id'         => 'required|array|min:1',
        'produk_id.*'       => 'required|exists:produks,id',
        'jumlah'            => 'required|array|min:1',
        'jumlah.*'          => 'required|integer|min:1',
    ]);
    

    DB::transaction(function () use ($request) {
        $total = 0;

        foreach ($request->produk_id as $i => $produkId) {
            $produk  = Produk::find($produkId);
            $jumlah  = $request->jumlah[$i];
            $total  += $produk->harga * $jumlah;
        }
        
        

        // Hitung diskon
        $diskon     = 0;
        $tipeDiskon = $request->tipe_diskon ?? 'nominal';

        if ($request->diskon && $request->diskon > 0) {
            if ($tipeDiskon == 'persen') {
                $diskon = $total * ($request->diskon / 100);
            } else {
                $diskon = $request->diskon;
            }
        }

        $grandTotal = $total - $diskon;

        // Hitung bayar berdasarkan tipe bayar
        if ($request->tipe_bayar == 'dp') {
            $bayar     = $request->dp ?? 0;
            $kembalian = 0;
            $status    = 'pending';
        } else {
            $bayar     = $request->bayar ?? $grandTotal;
            $kembalian = $bayar - $grandTotal;
            $status    = 'selesai';
        }

        $transaksi = Transaksi::create([
            'kode_transaksi'    => Transaksi::generateKode(),
            'pelanggan_id'      => $request->pelanggan_id,
            'user_id'           => auth()->id(),
            'total_harga'       => $total,
            'diskon'            => $diskon,
            'grand_total'       => $grandTotal,
            'metode_bayar'      => $request->metode_bayar,
            'bayar'             => $bayar,
            'kembalian'         => $kembalian,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'status'            => $status,
            'catatan'           => $request->catatan,
        ]);
                // Di store (setelah transaksi dibuat)
\App\Models\ActivityLog::catat(
    'Transaksi', 'create',
    'Membuat transaksi baru: ' . $transaksi->kode_transaksi,
    $transaksi
);


        // Tambah poin member otomatis
$pelanggan = Pelanggan::find($request->pelanggan_id);
if ($pelanggan->member && $pelanggan->member->status == 'aktif') {
    $poinDidapat = Member::hitungPoin($grandTotal);
    if ($poinDidapat > 0) {
        $pelanggan->member->increment('total_poin', $poinDidapat);
        $pelanggan->member->updateLevel();

        PoinRiwayat::create([
            'member_id'    => $pelanggan->member->id,
            'transaksi_id' => $transaksi->id,
            'tipe'         => 'masuk',
            'poin'         => $poinDidapat,
            'keterangan'   => 'Poin dari transaksi ' . $transaksi->kode_transaksi,
        ]);
    }
}

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

        // Buat hutang jika DP
        if ($request->tipe_bayar == 'dp') {
            $dp         = $request->dp ?? 0;
            $sisaHutang = $grandTotal - $dp;

            \App\Models\Hutang::create([
                'pelanggan_id'  => $request->pelanggan_id,
                'transaksi_id'  => $transaksi->id,
                'user_id'       => auth()->id(),
                'total_tagihan' => $grandTotal,
                'total_bayar'   => $dp,
                'sisa_hutang'   => $sisaHutang,
                'status'        => $sisaHutang <= 0 ? 'lunas' : 'belum_lunas',
                'jatuh_tempo'   => $request->jatuh_tempo,
                'catatan'       => 'DP Transaksi ' . $transaksi->kode_transaksi,
            ]);
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

    public function edit(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'details.produk']);
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $produks    = Produk::where('status', 'aktif')->get();
        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'produks'));
        
    }

    public function update(Request $request, Transaksi $transaksi)
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

        DB::transaction(function () use ($request, $transaksi) {
            foreach ($transaksi->details as $detail) {
                $detail->produk->increment('stok', $detail->jumlah);
            }

            $transaksi->details()->delete();

            $total = 0;
            foreach ($request->produk_id as $i => $produkId) {
                $produk  = Produk::find($produkId);
                $jumlah  = $request->jumlah[$i];
                $total  += $produk->harga * $jumlah;
            }

            $diskon     = 0;
            $tipeDiskon = $request->tipe_diskon ?? 'nominal';

            if ($request->diskon && $request->diskon > 0) {
                if ($tipeDiskon == 'persen') {
                    $diskon = $total * ($request->diskon / 100);
                } else {
                    $diskon = $request->diskon;
                }
            }

            $grandTotal = $total - $diskon;
            $bayar      = $request->bayar ?? $grandTotal;
            $kembalian  = $bayar - $grandTotal;

            $transaksi->update([
                'pelanggan_id'      => $request->pelanggan_id,
                'user_id'           => auth()->id(), // ← disini
                'total_harga'       => $total,
                'diskon'            => $diskon,
                'grand_total'       => $grandTotal,
                'metode_bayar'      => $request->metode_bayar,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status'            => $request->status ?? 'selesai',
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

        return redirect()->route('transaksi.show', $transaksi)
                         ->with('success', 'Transaksi berhasil diupdate!');
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
        // Di destroy
\App\Models\ActivityLog::catat(
    'Transaksi', 'delete',
    'Menghapus transaksi: ' . $transaksi->kode_transaksi
);
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