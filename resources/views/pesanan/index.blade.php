@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-box mr-2"></i>Status Pesanan
    </h1>
    <a href="{{ route('pesanan.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Buat Pesanan
    </a>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-secondary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                    Menunggu
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalMenunggu }} Pesanan
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Sedang Diproses
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalDiproses }} Pesanan
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Siap Diambil
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalSiapDiambil }} Pesanan
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Transaksi</th>
                        <th>Estimasi Selesai</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $p)
                    @php $label = $p->labelStatus(); @endphp
                    <tr>
                        <td><code>{{ $p->kode_pesanan }}</code></td>
                        <td><strong>{{ $p->pelanggan->nama }}</strong></td>
                        <td>
                            <a href="{{ route('transaksi.show', $p->transaksi) }}">
                                <code>{{ $p->transaksi->kode_transaksi }}</code>
                            </a>
                        </td>
                        <td>
                            @if($p->tanggal_estimasi)
                                {{ \Carbon\Carbon::parse($p->tanggal_estimasi)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $label['color'] }}">
                                {{ $label['label'] }}
                            </span>
                        </td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('pesanan.show', $p) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                            Belum ada pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pesanans->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection