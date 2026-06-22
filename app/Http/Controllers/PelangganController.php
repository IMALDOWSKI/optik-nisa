<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{

    public function riwayat(Pelanggan $pelanggan)
{
    $transaksis = $pelanggan->transaksis()
                    ->with('details.produk')
                    ->latest()
                    ->get();

    $resepMatas = $pelanggan->resepMatas()
                    ->latest()
                    ->get();

    $totalBelanja = $transaksis->sum('total_harga');

    return view('pelanggan.riwayat', compact(
        'pelanggan',
        'transaksis',
        'resepMatas',
        'totalBelanja'
    ));
}
    public function ajaxStore(Request $request)
{
    $request->validate([
        'nama'       => 'required',
        'no_telepon' => 'required',
        'alamat'     => 'required',
    ]);

    $pelanggan = Pelanggan::create([
        'nama'       => $request->nama,
        'no_telepon' => $request->no_telepon,
        'email'      => $request->email,
        'alamat'     => $request->alamat,
    ]);

    return response()->json([
        'success' => true,
        'id'      => $pelanggan->id,
        'nama'    => $pelanggan->nama,
    ]);
}

    public function index()
    {
        $pelanggans = Pelanggan::latest()->paginate(10);
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required',
        ]);

        Pelanggan::create($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
        // Di store
ActivityLog::catat('Pelanggan', 'create', 'Menambah pelanggan baru: ' . $pelanggan->nama, $pelanggan);
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required',
        ]);

        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diupdate!');
        // Di update  
ActivityLog::catat('Pelanggan', 'update', 'Mengupdate pelanggan: ' . $pelanggan->nama, $pelanggan);
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
        // Di destroy
ActivityLog::catat('Pelanggan', 'delete', 'Menghapus pelanggan: ' . $pelanggan->nama);
    }

    // Cari pelanggan untuk autocomplete (dipanggil dari form transaksi)
public function ajaxSearch(Request $request)
{
    $keyword = $request->get('q', '');

    $pelanggans = Pelanggan::where('nama', 'like', "%{$keyword}%")
                    ->orWhere('no_telepon', 'like', "%{$keyword}%")
                    ->orderBy('nama')
                    ->limit(10)
                    ->get(['id', 'nama', 'no_telepon', 'alamat']);

    return response()->json($pelanggans);
}

// Ambil riwayat resep mata seorang pelanggan (format JSON, untuk form transaksi)
public function ajaxRiwayatResep(Pelanggan $pelanggan)
{
    $resepMatas = $pelanggan->resepMatas()
                    ->latest('tanggal_periksa')
                    ->get();

    return response()->json($resepMatas);
}
}