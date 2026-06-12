<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AntrianController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $antrians = Antrian::whereDate('tanggal', $today)
                        ->orderBy('nomor_antrian')
                        ->get();

        $sedangDilayani = Antrian::whereDate('tanggal', $today)
                            ->where('status', 'dipanggil')
                            ->orderBy('dipanggil_at', 'desc')
                            ->first();

        $totalMenunggu = Antrian::whereDate('tanggal', $today)
                            ->where('status', 'menunggu')
                            ->count();

        $totalSelesai = Antrian::whereDate('tanggal', $today)
                            ->where('status', 'selesai')
                            ->count();

        return view('antrian.index', compact(
            'antrians', 'sedangDilayani', 'totalMenunggu', 'totalSelesai'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'nullable|string|max:255',
            'keperluan'      => 'required',
        ]);

        $antrian = Antrian::create([
            'nomor_antrian'  => Antrian::nomorBerikutnya(),
            'tanggal'        => Carbon::today(),
            'nama_pelanggan' => $request->nama_pelanggan,
            'keperluan'      => $request->keperluan,
            'status'         => 'menunggu',
        ]);

        return redirect()->route('antrian.index')
                         ->with('success', 'Nomor antrian ' . $antrian->nomor_antrian . ' berhasil dibuat!');
    }

    public function panggil(Antrian $antrian)
    {
        // Set antrian sebelumnya yang masih "dipanggil" jadi "selesai"
        Antrian::whereDate('tanggal', Carbon::today())
            ->where('status', 'dipanggil')
            ->update(['status' => 'selesai']);

        $antrian->update([
            'status'       => 'dipanggil',
            'dipanggil_at' => now(),
        ]);

        return redirect()->route('antrian.index')
                         ->with('success', 'Antrian nomor ' . $antrian->nomor_antrian . ' dipanggil!');
    }

    public function selesai(Antrian $antrian)
    {
        $antrian->update(['status' => 'selesai']);

        return redirect()->route('antrian.index')
                         ->with('success', 'Antrian selesai dilayani!');
    }

    public function batal(Antrian $antrian)
    {
        $antrian->update(['status' => 'batal']);

        return redirect()->route('antrian.index')
                         ->with('success', 'Antrian dibatalkan!');
    }

    public function reset()
    {
        Antrian::whereDate('tanggal', Carbon::today())->delete();

        return redirect()->route('antrian.index')
                         ->with('success', 'Semua antrian hari ini berhasil direset!');
    }

    // Halaman display untuk TV/monitor (tanpa login)
    public function display()
    {
        $today = Carbon::today();

        $sedangDilayani = Antrian::whereDate('tanggal', $today)
                            ->where('status', 'dipanggil')
                            ->orderBy('dipanggil_at', 'desc')
                            ->first();

        $menunggu = Antrian::whereDate('tanggal', $today)
                        ->where('status', 'menunggu')
                        ->orderBy('nomor_antrian')
                        ->limit(5)
                        ->get();

        return view('antrian.display', compact('sedangDilayani', 'menunggu'));
    }
}