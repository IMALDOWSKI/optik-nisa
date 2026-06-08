@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-tie mr-2"></i>Laporan Per Kasir
    </h1>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.kasir') }}" class="form-inline">
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">Bulan:</label>
                <select name="bulan" class="form-control">
                    @foreach($daftarBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">Tahun:</label>
                <select name="tahun" class="form-control">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter
            </button>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Performa Kasir — {{ $daftarBulan[$bulan] }} {{ $tahun }}
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kasir</th>
                        <th>Role</th>
                        <th>Total Transaksi</th>
                        <th>Total Pendapatan</th>
                        <th>Total Diskon</th>
                        <th>Rata-rata per Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataKasir as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $k->user->name ?? 'Unknown' }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-{{ $k->user->role == 'admin' ? 'danger' : 'info' }}">
                                {{ ucfirst($k->user->role ?? '-') }}
                            </span>
                        </td>
                        <td>{{ $k->total_transaksi }} transaksi</td>
                        <td>Rp {{ number_format($k->total_pendapatan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($k->total_diskon, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($k->rata_rata, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data pada periode ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection