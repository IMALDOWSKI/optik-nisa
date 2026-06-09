<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\ResepMata;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function index()
    {
        $satu_tahun_lalu   = Carbon::now()->subYear();
        $enam_bulan_lalu   = Carbon::now()->subMonths(6);
        $tiga_bulan_lalu   = Carbon::now()->subMonths(3);

        // Pelanggan yang BELUM pernah periksa sama sekali
        $belumPernahPeriksa = Pelanggan::doesntHave('resepMatas')->get();

        // Pelanggan yang sudah > 1 tahun tidak periksa
        $lebihSatuTahun = Pelanggan::whereHas('resepMatas', function($q) use ($satu_tahun_lalu) {
            $q->where('tanggal_periksa', '<', $satu_tahun_lalu);
        })->whereDoesntHave('resepMatas', function($q) use ($satu_tahun_lalu) {
            $q->where('tanggal_periksa', '>=', $satu_tahun_lalu);
        })->with(['resepMatas' => function($q) {
            $q->latest('tanggal_periksa')->limit(1);
        }])->get();

        // Pelanggan yang sudah 6-12 bulan tidak periksa
        $enamHingga12Bulan = Pelanggan::whereHas('resepMatas', function($q) use ($satu_tahun_lalu, $enam_bulan_lalu) {
            $q->where('tanggal_periksa', '<', $enam_bulan_lalu)
              ->where('tanggal_periksa', '>=', $satu_tahun_lalu);
        })->whereDoesntHave('resepMatas', function($q) use ($enam_bulan_lalu) {
            $q->where('tanggal_periksa', '>=', $enam_bulan_lalu);
        })->with(['resepMatas' => function($q) {
            $q->latest('tanggal_periksa')->limit(1);
        }])->get();

        return view('reminder.index', compact(
            'belumPernahPeriksa',
            'lebihSatuTahun',
            'enamHingga12Bulan'
        ));
    }
}