@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Jadwal</h1>
    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@php
    $labelJenis  = $jadwal->labelJenis();
    $labelStatus = $jadwal->labelStatus();

    $pesanWa = "Halo *" . $jadwal->pelanggan->nama . "*,\n\n"
             . "Booking Anda di *Optik Nisa* telah tercatat:\n\n"
             . "Kode: " . $jadwal->kode_jadwal . "\n"
             . "Jenis: " . $labelJenis['label'] . "\n"
             . "Tanggal: " . \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') . "\n"
             . "Jam: " . \Carbon\Carbon::parse($jadwal->jam)->format('H:i') . " WIB\n"
             . "Status: " . $labelStatus['label'] . "\n\n"
             . "Mohon datang tepat waktu. Terima kasih 😊";
@endphp

<div class="row">
    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-check mr-2"></i>{{ $jadwal->kode_jadwal }}
                </h6>
                <span class="badge badge-{{ $labelStatus['color'] }} px-3 py-2">
                    {{ $labelStatus['label'] }}
                </span>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" width="180">Pelanggan</td>
                        <td><strong>{{ $jadwal->pelanggan->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. Telepon</td>
                        <td>{{ $jadwal->pelanggan->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Booking</td>
                        <td>
                            <span class="badge badge-{{ $labelJenis['color'] }}">
                                {{ $labelJenis['label'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jam</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dibuat Oleh</td>
                        <td>{{ $jadwal->user->name }}</td>
                    </tr>
                </table>

                @if($jadwal->catatan)
                <div class="alert alert-info">
                    <i class="fas fa-sticky-note mr-2"></i>
                    <strong>Catatan:</strong> {{ $jadwal->catatan }}
                </div>
                @endif

                <a href="{{ \App\Helpers\WhatsappHelper::link($jadwal->pelanggan->no_telepon, $pesanWa) }}"
                   target="_blank" class="btn btn-success">
                    <i class="fab fa-whatsapp mr-2"></i>Kirim Konfirmasi via WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- Update Status --}}
    <div class="col-md-5">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit mr-2"></i>Update Status
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('jadwal.update-status', $jadwal) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Status Booking</label>
                        <select name="status" class="form-control">
                            @foreach(['menunggu' => 'Menunggu', 'dikonfirmasi' => 'Dikonfirmasi', 'selesai' => 'Selesai', 'batal' => 'Batal'] as $val => $txt)
                                <option value="{{ $val }}" {{ $jadwal->status == $val ? 'selected' : '' }}>
                                    {{ $txt }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection