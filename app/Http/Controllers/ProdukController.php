<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $query = Produk::latest();

        // Filter berdasarkan kategori
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        $produks = $query->paginate(10);
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'barcode'     => 'nullable|unique:produks,barcode',
        ]);

        $data = $request->all();
        $data['kode_produk'] = Produk::generateKode($request->kategori);

        $produk = Produk::create($data);

        ActivityLog::catat(
            modul: 'produk',
            aksi: 'create',
            deskripsi: 'Produk ditambahkan',
            model: $produk,
            dataLama: null,
            dataBaru: [
                'kode_produk' => $produk->kode_produk,
                'nama_produk' => $produk->nama_produk,
                'kategori'    => $produk->kategori,
                'stok'        => $produk->stok,
                'harga'       => $produk->harga,
                'barcode'     => $produk->barcode,
            ]
        );

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'barcode'     => 'nullable|unique:produks,barcode,' . $produk->id,
        ]);

        $produk->update($request->all());
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        // Activity Log
        ActivityLog::catat(
            modul: 'produk',
            aksi: 'delete',
            deskripsi: 'Produk dihapus',
            model: $produk,
            dataLama: [
                'kode_produk' => $produk->kode_produk,
                'nama_produk' => $produk->nama_produk,
                'kategori'    => $produk->kategori,
            ],
            dataBaru: null
        );

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }


    public function cetakBarcode(Produk $produk)
    {
        // Activity Log
        ActivityLog::catat(
            modul: 'produk',
            aksi: 'print',
            deskripsi: 'Cetak barcode produk',
            model: $produk,
            dataLama: null,
            dataBaru: [
                'kode_produk' => $produk->kode_produk,
            ]
        );

        return view('produk.barcode', compact('produk'));
    }

    public function cetakBarcodeMassal(Request $request)
    {
        // Activity Log
        ActivityLog::catat(
            modul: 'produk',
            aksi: 'print',
            deskripsi: 'Cetak barcode massal',
            model: null,
            dataLama: null,
            dataBaru: null
        );

        $produks = Produk::where('status', 'aktif')->get();
        return view('produk.barcode_massal', compact('produks'));
    }
}
