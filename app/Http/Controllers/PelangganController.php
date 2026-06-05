<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
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
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}