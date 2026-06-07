<?php

namespace App\Http\Controllers;

use App\Models\Restok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestokController extends Controller
{
    public function index()
    {
        $restoks = Restok::with(['produk', 'user'])->latest()->paginate(10);
        return view('restok.index', compact('restoks'));
    }

    public function create()
    {
        $produks = Produk::where('status', 'aktif')->orderBy('nama_produk')->get();
        return view('restok.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'      => 'required|exists:produks,id',
            'jumlah_tambah'  => 'required|integer|min:1',
            'tanggal_restok' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $produk = Produk::find($request->produk_id);
            $stokSebelum = $produk->stok;
            $stokSesudah = $stokSebelum + $request->jumlah_tambah;

            // Simpan riwayat restok
            Restok::create([
                'produk_id'      => $request->produk_id,
                'jumlah_tambah'  => $request->jumlah_tambah,
                'stok_sebelum'   => $stokSebelum,
                'stok_sesudah'   => $stokSesudah,
                'harga_beli'     => $request->harga_beli,
                'supplier'       => $request->supplier,
                'no_faktur'      => $request->no_faktur,
                'tanggal_restok' => $request->tanggal_restok,
                'catatan'        => $request->catatan,
                'user_id'        => auth()->id(),
            ]);

            // Update stok produk
            $produk->update(['stok' => $stokSesudah]);
        });

        return redirect()->route('restok.index')
                         ->with('success', 'Restok berhasil dicatat!');
    }

    public function show(Restok $restok)
    {
        $restok->load(['produk', 'user']);
        return view('restok.show', compact('restok'));
    }
}