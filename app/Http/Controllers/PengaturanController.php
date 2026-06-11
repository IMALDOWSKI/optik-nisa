<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $namaToko    = Pengaturan::get('nama_toko', 'Optik Nisa');
        $alamatToko  = Pengaturan::get('alamat_toko', '');
        $teleponToko = Pengaturan::get('telepon_toko', '');
        $qrisImage   = Pengaturan::get('qris_image');

        return view('pengaturan.index', compact(
            'namaToko', 'alamatToko', 'teleponToko', 'qrisImage'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_toko'    => 'required|string|max:255',
            'alamat_toko'  => 'nullable|string',
            'telepon_toko' => 'nullable|string|max:20',
            'qris_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Pengaturan::set('nama_toko', $request->nama_toko);
        Pengaturan::set('alamat_toko', $request->alamat_toko);
        Pengaturan::set('telepon_toko', $request->telepon_toko);

        // Upload QRIS image
        if ($request->hasFile('qris_image')) {
            // Hapus gambar lama
            $oldImage = Pengaturan::get('qris_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $path = $request->file('qris_image')->store('qris', 'public');
            Pengaturan::set('qris_image', $path);
        }

        return redirect()->route('pengaturan.index')
                         ->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function hapusQris()
    {
        $oldImage = Pengaturan::get('qris_image');
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }
        Pengaturan::set('qris_image', null);

        return redirect()->route('pengaturan.index')
                         ->with('success', 'QRIS berhasil dihapus!');
    }
}