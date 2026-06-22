<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\ResepMata;
use App\Models\Member;
use App\Models\PoinRiwayat;
use App\Models\Hutang;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiTerpaduController extends Controller
{
    public function create()
    {
        $produks = Produk::where('status', 'aktif')->where('stok', '>', 0)->get();
        return view('transaksi-terpadu.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Pelanggan
            'pelanggan_id'      => 'required|exists:pelanggans,id',

            // Resep — boleh kosong kalau transaksi tidak butuh resep (misal cuma beli aksesoris)
            'resep_mode'        => 'required|in:lama,baru,tidak_ada',
            'resep_id'          => 'nullable|exists:resep_matas,id',

            // Item produk
            'item_jenis'        => 'required|array|min:1',
            'item_jenis.*'      => 'required|in:produk,frame_sendiri',
            'item_produk_id'    => 'nullable|array',
            'item_jumlah'       => 'required|array|min:1',
            'item_jumlah.*'     => 'required|integer|min:1',

            // Checkout
            'tanggal_transaksi' => 'required|date',
            'metode_bayar'      => 'required',
            'tipe_bayar'        => 'required|in:lunas,dp',
        ]);

        $transaksi = DB::transaction(function () use ($request) {

            // ===== 1. PELANGGAN =====
            $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);

            // ===== 2. RESEP MATA =====
            $resepId = null;

            if ($request->resep_mode === 'lama') {
                $resepId = $request->resep_id;
            } elseif ($request->resep_mode === 'baru') {
                $resep = ResepMata::create([
                    'pelanggan_id'    => $pelanggan->id,
                    'od_sph'          => $request->od_sph,
                    'od_cyl'          => $request->od_cyl,
                    'od_axis'         => $request->od_axis,
                    'od_add'          => $request->od_add,
                    'os_sph'          => $request->os_sph,
                    'os_cyl'          => $request->os_cyl,
                    'os_axis'         => $request->os_axis,
                    'os_add'          => $request->os_add,
                    'pd_kanan'        => $request->pd_kanan,
                    'pd_kiri'         => $request->pd_kiri,
                    'tanggal_periksa' => $request->tanggal_transaksi,
                    'dokter'          => $request->dokter,
                    'catatan'         => $request->catatan_resep,
                ]);
                $resepId = $resep->id;
            }
            // kalau 'tidak_ada', $resepId tetap null

            // ===== 3. HITUNG TOTAL ITEM =====
            $total = 0;
            $itemsToSave = [];

            foreach ($request->item_jenis as $i => $jenis) {
                $jumlah = $request->item_jumlah[$i];

                if ($jenis === 'frame_sendiri') {
                    // Frame bawa sendiri — harga 0, tidak potong stok
                    $itemsToSave[] = [
                        'produk_id'                => null,
                        'jumlah'                    => $jumlah,
                        'harga_satuan'              => 0,
                        'subtotal'                  => 0,
                        'is_frame_sendiri'          => true,
                        'keterangan_frame_sendiri'  => $request->item_keterangan_frame[$i] ?? null,
                    ];
                } else {
                    $produkId = $request->item_produk_id[$i];
                    $produk   = Produk::findOrFail($produkId);
                    $subtotal = $produk->harga * $jumlah;
                    $total   += $subtotal;

                    $itemsToSave[] = [
                        'produk_id'                => $produk->id,
                        'jumlah'                    => $jumlah,
                        'harga_satuan'              => $produk->harga,
                        'subtotal'                  => $subtotal,
                        'is_frame_sendiri'          => false,
                        'keterangan_frame_sendiri'  => null,
                    ];
                }
            }

            // ===== 4. DISKON =====
            $diskon     = 0;
            $tipeDiskon = $request->tipe_diskon ?? 'nominal';

            if ($request->diskon && $request->diskon > 0) {
                $diskon = $tipeDiskon === 'persen'
                    ? $total * ($request->diskon / 100)
                    : $request->diskon;
            }

            $grandTotal = $total - $diskon;

            // ===== 5. BAYAR =====
            if ($request->tipe_bayar === 'dp') {
                $bayar     = $request->dp ?? 0;
                $kembalian = 0;
                $status    = 'pending';
            } else {
                $bayar     = $request->bayar ?? $grandTotal;
                $kembalian = $bayar - $grandTotal;
                $status    = 'selesai';
            }

            // ===== 6. SIMPAN TRANSAKSI =====
            $transaksi = Transaksi::create([
                'kode_transaksi'    => Transaksi::generateKode(),
                'pelanggan_id'      => $pelanggan->id,
                'user_id'           => auth()->id(),
                'resep_mata_id'     => $resepId,
                'total_harga'       => $total,
                'diskon'            => $diskon,
                'grand_total'       => $grandTotal,
                'metode_bayar'      => $request->metode_bayar,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status'            => $status,
                'catatan'           => $request->catatan,
            ]);

            ActivityLog::catat(
                'Transaksi', 'create',
                'Membuat transaksi (terpadu): ' . $transaksi->kode_transaksi,
                $transaksi
            );

            // ===== 7. SIMPAN DETAIL ITEM + POTONG STOK =====
            foreach ($itemsToSave as $item) {
                DetailTransaksi::create(array_merge($item, [
                    'transaksi_id' => $transaksi->id,
                ]));

                if (!$item['is_frame_sendiri']) {
                    Produk::find($item['produk_id'])->decrement('stok', $item['jumlah']);
                }
            }

            // ===== 8. POIN MEMBER =====
            if ($pelanggan->member && $pelanggan->member->status === 'aktif') {
                $poinDidapat = Member::hitungPoin($grandTotal);
                if ($poinDidapat > 0) {
                    $pelanggan->member->increment('total_poin', $poinDidapat);
                    $pelanggan->member->updateLevel();

                    PoinRiwayat::create([
                        'member_id'    => $pelanggan->member->id,
                        'transaksi_id' => $transaksi->id,
                        'tipe'         => 'masuk',
                        'poin'         => $poinDidapat,
                        'keterangan'   => 'Poin dari transaksi ' . $transaksi->kode_transaksi,
                    ]);
                }
            }

            // ===== 9. HUTANG (kalau DP) =====
            if ($request->tipe_bayar === 'dp') {
                $sisaHutang = $grandTotal - $bayar;

                Hutang::create([
                    'pelanggan_id'  => $pelanggan->id,
                    'transaksi_id'  => $transaksi->id,
                    'user_id'       => auth()->id(),
                    'total_tagihan' => $grandTotal,
                    'total_bayar'   => $bayar,
                    'sisa_hutang'   => $sisaHutang,
                    'status'        => $sisaHutang <= 0 ? 'lunas' : 'belum_lunas',
                    'jatuh_tempo'   => $request->jatuh_tempo,
                    'catatan'       => 'DP Transaksi ' . $transaksi->kode_transaksi,
                ]);
            }

            return $transaksi;
        });

        return redirect()->route('transaksi.show', $transaksi)
                         ->with('success', 'Transaksi berhasil disimpan!');
    }
}