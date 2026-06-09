@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-chart-line mr-2"></i>Laporan Laba Rugi
    </h1>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laba-rugi.index') }}" class="form-inline">
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
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>
    </div>
</div>

{{-- Ringkasan Laba Rugi --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Total Pendapatan
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
                <small class="text-muted">
                    Diskon: Rp {{ number_format($totalDiskon, 0, ',', '.') }}
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Total Pengeluaran
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </div>
                <small class="text-muted">
                    Modal Restok: Rp {{ number_format($totalModal, 0, ',', '.') }}
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-{{ $labaBersih >= 0 ? 'primary' : 'danger' }} shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-{{ $labaBersih >= 0 ? 'primary' : 'danger' }} text-uppercase mb-1">
                    Laba Bersih
                </div>
                <div class="h5 font-weight-bold text-{{ $labaBersih >= 0 ? 'success' : 'danger' }}">
                    {{ $labaBersih >= 0 ? '+' : '' }}Rp {{ number_format($labaBersih, 0, ',', '.') }}
                </div>
                <small class="text-muted">
                    Laba Kotor: Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Grafik --}}
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Laba Rugi 6 Bulan Terakhir
                </h6>
            </div>
            <div class="card-body">
                <canvas id="grafikLabaRugi"></canvas>
            </div>
        </div>
    </div>

    {{-- Rincian --}}
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Rincian {{ $daftarBulan[$bulan] }} {{ $tahun }}
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr class="bg-success text-white">
                            <td colspan="2" class="font-weight-bold">
                                <i class="fas fa-plus-circle mr-2"></i>PENDAPATAN
                            </td>
                        </tr>
                        <tr>
                            <td>Penjualan</td>
                            <td class="text-right">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Diskon Diberikan</td>
                            <td class="text-right text-danger">
                                - Rp {{ number_format($totalDiskon, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="bg-danger text-white">
                            <td colspan="2" class="font-weight-bold">
                                <i class="fas fa-minus-circle mr-2"></i>PENGELUARAN
                            </td>
                        </tr>
                        <tr>
                            <td>Modal Restok</td>
                            <td class="text-right text-danger">
                                - Rp {{ number_format($totalModal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @foreach($pengeluaranPerKategori as $k)
                        <tr>
                            <td>
                                {{ \App\Models\Pengeluaran::daftarKategori()[$k->kategori] ?? $k->kategori }}
                            </td>
                            <td class="text-right text-danger">
                                - Rp {{ number_format($k->total, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg-light">
                            <td><strong>Total Pengeluaran</strong></td>
                            <td class="text-right text-danger font-weight-bold">
                                - Rp {{ number_format($totalPengeluaran + $totalModal, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="bg-{{ $labaBersih >= 0 ? 'primary' : 'danger' }} text-white">
                            <td><strong>LABA BERSIH</strong></td>
                            <td class="text-right font-weight-bold">
                                {{ $labaBersih >= 0 ? '+' : '' }}Rp {{ number_format($labaBersih, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('grafikLabaRugi').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikLabel) !!},
            datasets: [
                {
                    label: 'Pendapatan',
                    data: {!! json_encode($grafikPendapatan) !!},
                    backgroundColor: 'rgba(28, 200, 138, 0.6)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                },
                {
                    label: 'Pengeluaran',
                    data: {!! json_encode($grafikPengeluaran) !!},
                    backgroundColor: 'rgba(231, 74, 59, 0.6)',
                    borderColor: 'rgba(231, 74, 59, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                },
                {
                    label: 'Laba',
                    data: {!! json_encode($grafikLaba) !!},
                    backgroundColor: 'rgba(26, 58, 92, 0.6)',
                    borderColor: 'rgba(26, 58, 92, 1)',
                    borderWidth: 2,
                    borderRadius: 4,
                    type: 'line',
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': Rp ' + ctx.raw.toLocaleString('id-ID')
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