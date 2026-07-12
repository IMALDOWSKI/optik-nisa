@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-money-bill-wave mr-2"></i>{{ __('menu.laporan_keuangan_tahunan') }}
    </h1>
</div>

{{-- Filter Tahun --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.keuangan') }}" class="form-inline">
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">{{ __('menu.tahun') }}:</label>
                <select name="tahun" class="form-control">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> {{ __('menu.tampilkan') }}
            </button>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    {{ __('menu.total_pendapatan') }} {{ $tahun }}
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalTahunIni, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    {{ __('menu.total_diskon') }} {{ $tahun }}
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalDiskon, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    {{ __('menu.total_transaksi') }} {{ $tahun }}
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $totalTransaksi }} Transaksi
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik & Tabel --}}
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('menu.grafik_pendapatan_per_bulan') }} {{ $tahun }}
                </h6>
            </div>
            <div class="card-body">
                <canvas id="grafikKeuangan"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('menu.detail_per_bulan') }}
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Bulan</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendapatanPerBulan as $nama => $nilai)
                            <tr>
                                <td>{{ $nama }}</td>
                                <td>
                                    @if($nilai > 0)
                                        <span class="text-success font-weight-bold">
                                            Rp {{ number_format($nilai, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td>Total</td>
                                <td>Rp {{ number_format($totalTahunIni, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('grafikKeuangan').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($pendapatanPerBulan)) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode(array_values($pendapatanPerBulan)) !!},
                backgroundColor: 'rgba(26, 58, 92, 0.1)',
                borderColor: 'rgba(26, 58, 92, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1a3a5c',
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection