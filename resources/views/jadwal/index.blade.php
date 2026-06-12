@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-calendar-alt mr-2"></i>Jadwal & Booking
    </h1>
    <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Buat Jadwal Baru
    </a>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Jadwal Hari Ini
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalHariIni }} Booking
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-secondary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                    Menunggu Konfirmasi
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalMenunggu }} Booking
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Sudah Dikonfirmasi
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalDikonfirmasi }} Booking
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('jadwal.index') }}" class="form-inline">
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">Tanggal:</label>
                <input type="date" name="tanggal" class="form-control form-control-sm"
                       value="{{ request('tanggal') }}">
            </div>
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">Status:</label>
                <select name="status" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    @foreach(['menunggu' => 'Menunggu', 'dikonfirmasi' => 'Dikonfirmasi', 'selesai' => 'Selesai', 'batal' => 'Batal'] as $val => $txt)
                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                            {{ $txt }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-search mr-1"></i>Filter
            </button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary btn-sm ml-1">
                Reset
            </a>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                    @php
                        $labelJenis  = $j->labelJenis();
                        $labelStatus = $j->labelStatus();
                        $isHariIni   = \Carbon\Carbon::parse($j->tanggal)->isToday();
                    @endphp
                    <tr class="{{ $isHariIni ? 'table-warning' : '' }}">
                        <td><code>{{ $j->kode_jadwal }}</code></td>
                        <td><strong>{{ $j->pelanggan->nama }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $labelJenis['color'] }}">
                                {{ $labelJenis['label'] }}
                            </span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}
                            @if($isHariIni)
                                <span class="badge badge-warning">Hari Ini</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($j->jam)->format('H:i') }}</td>
                        <td>
                            <span class="badge badge-{{ $labelStatus['color'] }}">
                                {{ $labelStatus['label'] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('jadwal.show', $j) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('jadwal.destroy', $j) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus jadwal ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                            Belum ada jadwal booking
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{ $jadwals->links('pagination::bootstrap-4') }}
@endsection