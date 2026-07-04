<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\ActivityLog;
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
        $dataLama = [
            'sudah_dibaca' => $notifikasi->sudah_dibaca,
        ];

        $notifikasi->update(['sudah_dibaca' => true]);

        ActivityLog::catat(
            modul: 'notifikasi',
            aksi: 'update',
            deskripsi: 'Notifikasi ditandai dibaca',
            model: $notifikasi,
            dataLama: $dataLama,
            dataBaru: [
                'sudah_dibaca' => true,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function tandaiSemuaBaca()
    {
        Notifikasi::where('sudah_dibaca', false)->update(['sudah_dibaca' => true]);

        ActivityLog::catat(
            modul: 'notifikasi',
            aksi: 'update',
            deskripsi: 'Semua notifikasi ditandai sudah dibaca',
            model: null,
            dataLama: null,
            dataBaru: null
        );

        return redirect()->route('notifikasi.index')
                         ->with('success', 'Semua notifikasi ditandai sudah dibaca!');
    }

    public function hapus(Notifikasi $notifikasi)
    {
        ActivityLog::catat(
            modul: 'notifikasi',
            aksi: 'delete',
            deskripsi: 'Notifikasi dihapus',
            model: $notifikasi,
            dataLama: [
                'id' => $notifikasi->id,
                'judul' => $notifikasi->judul,
            ],
            dataBaru: null
        );

        $notifikasi->delete();
        return redirect()->route('notifikasi.index')
                         ->with('success', 'Notifikasi dihapus!');
    }

    public function hapusSemua()
    {
        $deleted = Notifikasi::where('sudah_dibaca', true)->count();

        ActivityLog::catat(
            modul: 'notifikasi',
            aksi: 'delete',
            deskripsi: 'Notifikasi yang sudah dibaca dihapus',
            model: null,
            dataLama: [
                'terhapus' => $deleted,
            ],
            dataBaru: null
        );

        Notifikasi::where('sudah_dibaca', true)->delete();
        return redirect()->route('notifikasi.index')
                         ->with('success', 'Notifikasi yang sudah dibaca dihapus!');
    }
}

