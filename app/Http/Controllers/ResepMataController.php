<?php

namespace App\Http\Controllers;

use App\Models\ResepMata;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ResepMataController extends Controller
{
    public function index()
    {
        $reseps = ResepMata::with('pelanggan')->latest()->paginate(10);
        return view('resep.index', compact('reseps'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('resep.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'    => 'required',
            'tanggal_periksa' => 'required|date',
        ]);

        ResepMata::create($request->all());
        return redirect()->route('resep.index')->with('success', 'Resep mata berhasil disimpan!');
    }

    public function show(ResepMata $resep)
    {
        return view('resep.show', compact('resep'));
    }

    public function edit(ResepMata $resep)
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('resep.edit', compact('resep', 'pelanggans'));
    }

    public function update(Request $request, ResepMata $resep)
    {
        $request->validate([
            'pelanggan_id'    => 'required',
            'tanggal_periksa' => 'required|date',
        ]);

        $resep->update($request->all());
        return redirect()->route('resep.index')->with('success', 'Resep mata berhasil diupdate!');
    }

    public function destroy(ResepMata $resep)
    {
        $resep->delete();
        return redirect()->route('resep.index')->with('success', 'Resep mata berhasil dihapus!');
    }
}