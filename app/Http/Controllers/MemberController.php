<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Pelanggan;
use App\Models\PoinRiwayat;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('pelanggan')
                        ->latest()->paginate(10);

        $totalMember   = Member::where('status', 'aktif')->count();
        $totalSilver   = Member::where('level', 'silver')->count();
        $totalGold     = Member::where('level', 'gold')->count();
        $totalPlatinum = Member::where('level', 'platinum')->count();

        return view('member.index', compact(
            'members', 'totalMember',
            'totalSilver', 'totalGold', 'totalPlatinum'
        ));
    }

    public function create()
    {
        // Hanya pelanggan yang belum jadi member
        $pelanggans = Pelanggan::doesntHave('member')
                        ->orderBy('nama')->get();
        return view('member.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id|unique:members,pelanggan_id',
        ]);

        Member::create([
            'pelanggan_id'    => $request->pelanggan_id,
            'no_member'       => Member::generateNoMember(),
            'level'           => 'silver',
            'total_poin'      => 0,
            'tanggal_bergabung' => now()->toDateString(),
            'status'          => 'aktif',
        ]);

        return redirect()->route('member.index')
                         ->with('success', 'Member berhasil didaftarkan!');
    }

    public function show(Member $member)
    {
        $member->load(['pelanggan', 'poinRiwayats.transaksi']);
        return view('member.show', compact('member'));
    }

    public function tukarPoin(Request $request, Member $member)
    {
        $request->validate([
            'poin_ditukar' => 'required|integer|min:1|max:' . $member->poinAktif(),
        ]);

        $nilaiDiskon = Member::nilaiPoin($request->poin_ditukar);

        // Catat riwayat penukaran poin
        PoinRiwayat::create([
            'member_id'   => $member->id,
            'tipe'        => 'keluar',
            'poin'        => $request->poin_ditukar,
            'keterangan'  => 'Penukaran poin senilai Rp ' . number_format($nilaiDiskon, 0, ',', '.'),
        ]);

        // Update poin member
        $member->increment('total_poin_digunakan', $request->poin_ditukar);

        return redirect()->route('member.show', $member)
                         ->with('success', 'Poin berhasil ditukar! Diskon Rp ' . number_format($nilaiDiskon, 0, ',', '.'));
    }
}