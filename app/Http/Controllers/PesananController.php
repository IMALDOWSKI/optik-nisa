<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\RiwayatStatusPesanan;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['pelanggan', 'transaksi'])
                        ->latest()->paginate(10);

        $totalMenunggu     = Pesanan::where('status', 'menunggu')->count();
        $totalDiproses     = Pesanan::where('status', 'diproses')->count();
        $totalSiapDiambil  = Pesanan::where('status', 'siap_diambil')->count();

        return view('pesanan.index', compact(
            'pesanans', 'totalMenunggu',
            'totalDiproses', 'totalSiapDiambil'
        ));
    }

    public function create()
    {
        $transaksis = Transaksi::with('pelanggan')
                        ->whereDoesntHave('pesanan')
                        ->latest()->get();
        $pelanggans = Pelanggan::orderBy('nama')->get();

        return view('pesanan.create', compact('transaksis', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id'     => 'required|exists:transaksis,id',
            'pelanggan_id'     => 'required|exists:pelanggans,id',
            'tanggal_estimasi' => 'nullable|date',
            'catatan'          => 'nullable|string',
        ]);

        $pesanan = Pesanan::create([
            'kode_pesanan'     => Pesanan::generateKode(),
            'transaksi_id'     => $request->transaksi_id,
            'pelanggan_id'     => $request->pelanggan_id,
            'user_id'          => auth()->id(),
            'status'           => 'menunggu',
            'tanggal_estimasi' => $request->tanggal_estimasi,
            'catatan'          => $request->catatan,
            'catatan_internal' => $request->catatan_internal,
        ]);

        // Catat riwayat pertama
        RiwayatStatusPesanan::create([
            'pesanan_id'  => $pesanan->id,
            'user_id'     => auth()->id(),
            'status'      => 'menunggu',
            'keterangan'  => 'Pesanan dibuat',
        ]);

        // Activity Log
        ActivityLog::catat(
            modul: 'pesanan',
            aksi: 'create',
            deskripsi: 'Pesanan dibuat',
            model: $pesanan,
            dataLama: null,
            dataBaru: [
                'kode_pesanan' => $pesanan->kode_pesanan,
                'status'       => $pesanan->status,
                'pelanggan_id' => $pesanan->pelanggan_id,
            ]
        );

        return redirect()->route('pesanan.show', $pesanan)
                         ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['pelanggan', 'transaksi.details.produk', 'riwayats.user']);

        return view('pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status'     => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $pesanan->update([
            'status'          => $request->status,
            'tanggal_selesai' => in_array($request->status, ['selesai_dibuat', 'siap_diambil', 'sudah_diambil'])
                                    ? now()->toDateString()
                                    : $pesanan->tanggal_selesai,
        ]);

        RiwayatStatusPesanan::create([
            'pesanan_id'  => $pesanan->id,
            'user_id'     => auth()->id(),
            'status'      => $request->status,
            'keterangan'  => $request->keterangan,
        ]);

        ActivityLog::catat(
            modul: 'pesanan',
            aksi: 'update',
            deskripsi: 'Status pesanan diupdate',
            model: $pesanan,
            dataLama: [
                'status' => $pesanan->getOriginal('status'),
            ],
            dataBaru: [
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'tanggal_selesai' => $pesanan->tanggal_selesai,
            ]
        );

        return redirect()->route('pesanan.show', $pesanan)
                          ->with('success', 'Status pesanan berhasil diupdate!');
    }
}

