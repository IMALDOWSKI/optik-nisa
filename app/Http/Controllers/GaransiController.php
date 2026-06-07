<?php

namespace App\Http\Controllers;

use App\Models\Garansi;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;

class GaransiController extends Controller
{
    public function index()
    {
        // Update status expired otomatis
        Garansi::updateStatusExpired();

        $garansis = Garansi::with(['pelanggan', 'produk', 'transaksi'])
                        ->latest()
                        ->paginate(10);

        $totalAktif   = Garansi::where('status', 'aktif')->count();
        $totalKlaim   = Garansi::where('status', 'klaim')->count();
        $totalExpired = Garansi::where('status', 'expired')->count();

        return view('garansi.index', compact(
            'garansis', 'totalAktif', 'totalKlaim', 'totalExpired'
        ));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $transaksis = Transaksi::with('pelanggan')->latest()->get();
        $produks    = Produk::where('status', 'aktif')->get();
        return view('garansi.create', compact('pelanggans', 'transaksis', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id'    => 'required|exists:transaksis,id',
            'pelanggan_id'    => 'required|exists:pelanggans,id',
            'produk_id'       => 'required|exists:produks,id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        Garansi::create([
            'transaksi_id'    => $request->transaksi_id,
            'pelanggan_id'    => $request->pelanggan_id,
            'produk_id'       => $request->produk_id,
            'no_garansi'      => Garansi::generateNoGaransi(),
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status'          => 'aktif',
            'ketentuan'       => $request->ketentuan,
        ]);

        return redirect()->route('garansi.index')
                         ->with('success', 'Garansi berhasil ditambahkan!');
    }

    public function show(Garansi $garansi)
    {
        $garansi->load(['pelanggan', 'produk', 'transaksi']);
        return view('garansi.show', compact('garansi'));
    }

    public function klaim(Request $request, Garansi $garansi)
    {
        $request->validate([
            'catatan_klaim' => 'required',
        ]);

        $garansi->update([
            'status'         => 'klaim',
            'catatan_klaim'  => $request->catatan_klaim,
            'tanggal_klaim'  => now()->toDateString(),
        ]);

        return redirect()->route('garansi.show', $garansi)
                         ->with('success', 'Garansi berhasil diklaim!');
    }
}