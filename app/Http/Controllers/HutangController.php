<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\PembayaranHutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HutangController extends Controller
{
    public function index()
    {
        $hutangs = Hutang::with(['pelanggan', 'transaksi'])
                    ->latest()
                    ->paginate(10);

        $totalHutang  = Hutang::where('status', 'belum_lunas')->sum('sisa_hutang');
        $totalLunas   = Hutang::where('status', 'lunas')->count();
        $totalBelumLunas = Hutang::where('status', 'belum_lunas')->count();

        return view('hutang.index', compact(
            'hutangs', 'totalHutang',
            'totalLunas', 'totalBelumLunas'
        ));
    }

    public function show(Hutang $hutang)
    {
        $hutang->load(['pelanggan', 'transaksi', 'pembayarans.user']);
        return view('hutang.show', compact('hutang'));
    }

    public function bayar(Request $request, Hutang $hutang)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1|max:' . $hutang->sisa_hutang,
            'metode_bayar' => 'required',
            'tanggal_bayar'=> 'required|date',
        ]);

        DB::transaction(function () use ($request, $hutang) {
            // Simpan pembayaran
            PembayaranHutang::create([
                'hutang_id'     => $hutang->id,
                'user_id'       => auth()->id(),
                'jumlah_bayar'  => $request->jumlah_bayar,
                'tanggal_bayar' => $request->tanggal_bayar,
                'metode_bayar'  => $request->metode_bayar,
                'catatan'       => $request->catatan,
            ]);

            // Update hutang
            $totalBayar = $hutang->total_bayar + $request->jumlah_bayar;
            $sisaHutang = $hutang->total_tagihan - $totalBayar;

            $hutang->update([
                'total_bayar' => $totalBayar,
                'sisa_hutang' => $sisaHutang,
                'status'      => $sisaHutang <= 0 ? 'lunas' : 'belum_lunas',
            ]);

            // Update status transaksi jika lunas
            if ($sisaHutang <= 0) {
                $hutang->transaksi->update(['status' => 'selesai']);
            }
        });

        return redirect()->route('hutang.show', $hutang)
                         ->with('success', 'Pembayaran berhasil dicatat!');
    }
}