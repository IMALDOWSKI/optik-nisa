<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        // Generate notifikasi terbaru
        Notifikasi::cekStokMenipis();
        Notifikasi::cekPelangganTidakAktif();
        Notifikasi::cekReminderKontrolMata();

        $notifikasis = Notifikasi::latest()->paginate(15);
        $belumDibaca = Notifikasi::where('sudah_dibaca', false)->count();

        return view('notifikasi.index', compact('notifikasis', 'belumDibaca'));
    }

    public function tandaiBaca(Notifikasi $notifikasi)
    {
        $notifikasi->update(['sudah_dibaca' => true]);
        return response()->json(['success' => true]);
    }

    public function tandaiSemuaBaca()
    {
        Notifikasi::where('sudah_dibaca', false)->update(['sudah_dibaca' => true]);
        return redirect()->route('notifikasi.index')
                         ->with('success', 'Semua notifikasi ditandai sudah dibaca!');
    }

    public function hapus(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return redirect()->route('notifikasi.index')
                         ->with('success', 'Notifikasi dihapus!');
    }

    public function hapusSemua()
    {
        Notifikasi::where('sudah_dibaca', true)->delete();
        return redirect()->route('notifikasi.index')
                         ->with('success', 'Notifikasi yang sudah dibaca dihapus!');
    }
}