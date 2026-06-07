<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required',
        ]);

        Supplier::create([
            'kode_supplier' => Supplier::generateKode(),
            'nama'          => $request->nama,
            'no_telepon'    => $request->no_telepon,
            'email'         => $request->email,
            'alamat'        => $request->alamat,
            'kontak_person' => $request->kontak_person,
            'status'        => $request->status ?? 'aktif',
            'catatan'       => $request->catatan,
        ]);

        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function show(Supplier $supplier)
    {
        $restoks = $supplier->restoks()
                    ->with('produk')
                    ->latest()
                    ->get();
        return view('supplier.show', compact('supplier', 'restoks'));
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama'       => 'required',
            'no_telepon' => 'required',
            'alamat'     => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil diupdate!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil dihapus!');
    }
}