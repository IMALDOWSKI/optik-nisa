<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $pengeluarans = Pengeluaran::with('user')
                            ->whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->latest()
                            ->paginate(10);

        $totalBulanIni = Pengeluaran::whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->sum('jumlah');

        $perKategori = Pengeluaran::whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->selectRaw('kategori, SUM(jumlah) as total')
                            ->groupBy('kategori')
                            ->get();

        $daftarBulan = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember'
        ];

        return view('pengeluaran.index', compact(
            'pengeluarans', 'totalBulanIni',
            'perKategori', 'bulan', 'tahun', 'daftarBulan'
        ));
    }

    public function create()
    {
        $kategori = Pengeluaran::daftarKategori();
        return view('pengeluaran.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'kategori' => 'required',
            'jumlah'   => 'required|numeric|min:1',
            'tanggal'  => 'required|date',
        ]);

        Pengeluaran::create([
            'user_id'  => auth()->id(),
            'judul'    => $request->judul,
            'kategori' => $request->kategori,
            'jumlah'   => $request->jumlah,
            'tanggal'  => $request->tanggal,
            'catatan'  => $request->catatan,
        ]);

        return redirect()->route('pengeluaran.index')
                         ->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index')
                         ->with('success', 'Pengeluaran berhasil dihapus!');
    }
}