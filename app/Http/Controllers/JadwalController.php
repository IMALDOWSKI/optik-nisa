<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['pelanggan', 'user']);

        // Filter tanggal
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default tampilkan dari hari ini ke depan
            $query->whereDate('tanggal', '>=', Carbon::today());
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $jadwals = $query->orderBy('tanggal')->orderBy('jam')->paginate(15);

        $totalHariIni     = Jadwal::whereDate('tanggal', Carbon::today())
                                ->whereIn('status', ['menunggu', 'dikonfirmasi'])
                                ->count();
        $totalMenunggu    = Jadwal::where('status', 'menunggu')->count();
        $totalDikonfirmasi = Jadwal::where('status', 'dikonfirmasi')->count();

        return view('jadwal.index', compact(
            'jadwals', 'totalHariIni', 'totalMenunggu', 'totalDikonfirmasi'
        ));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('jadwal.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jenis'        => 'required',
            'tanggal'      => 'required|date',
            'jam'          => 'required',
            'catatan'      => 'nullable|string',
        ]);

        $jadwal = Jadwal::create([
            'kode_jadwal'  => Jadwal::generateKode(),
            'pelanggan_id' => $request->pelanggan_id,
            'user_id'      => auth()->id(),
            'jenis'        => $request->jenis,
            'tanggal'      => $request->tanggal,
            'jam'          => $request->jam,
            'status'       => 'menunggu',
            'catatan'      => $request->catatan,
        ]);

        return redirect()->route('jadwal.index')
                         ->with('success', 'Jadwal booking berhasil dibuat!');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['pelanggan', 'user']);
        return view('jadwal.show', compact('jadwal'));
    }

    public function updateStatus(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,selesai,batal',
        ]);

        $jadwal->update(['status' => $request->status]);

        return redirect()->route('jadwal.show', $jadwal)
                         ->with('success', 'Status jadwal berhasil diupdate!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')
                         ->with('success', 'Jadwal berhasil dihapus!');
    }
}