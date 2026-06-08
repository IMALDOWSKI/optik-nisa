@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-file-invoice-dollar mr-2"></i>Hutang Pelanggan
    </h1>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Total Hutang Belum Lunas
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalHutang, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Jumlah Belum Lunas
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalBelumLunas }} Hutang
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Sudah Lunas
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalLunas }} Hutang
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
                        <th>Pelanggan</th>
                        <th>Transaksi</th>
                        <th>Total Tagihan</th>
                        <th>Sudah Bayar</th>
                        <th>Sisa Hutang</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hutangs as $h)
                    <tr>
                        <td><strong>{{ $h->pelanggan->nama }}</strong></td>
                        <td>
                            <a href="{{ route('transaksi.show', $h->transaksi) }}">
                                <code>{{ $h->transaksi->kode_transaksi }}</code>
                            </a>
                        </td>
                        <td>Rp {{ number_format($h->total_tagihan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($h->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <strong class="text-{{ $h->status == 'lunas' ? 'success' : 'danger' }}">
                                Rp {{ number_format($h->sisa_hutang, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td>
                            @if($h->jatuh_tempo)
                                @php
                                    $jatuhTempo = \Carbon\Carbon::parse($h->jatuh_tempo);
                                    $isLewat    = $jatuhTempo->isPast() && $h->status == 'belum_lunas';
                                @endphp
                                <span class="{{ $isLewat ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $jatuhTempo->format('d/m/Y') }}
                                    @if($isLewat) ⚠️ @endif
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $h->status == 'lunas' ? 'success' : 'danger' }}">
                                {{ $h->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('hutang.show', $h) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-check-circle text-success fa-2x mb-2 d-block"></i>
                            Tidak ada hutang!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $hutangs->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
