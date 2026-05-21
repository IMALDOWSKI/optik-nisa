<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $totalProduk    = Produk::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::where('status', 'selesai')->sum('total_harga');

        return view('dashboard', compact(
            'totalPelanggan',
            'totalProduk',
            'totalTransaksi',
            'totalPendapatan'
        ));
    }
}