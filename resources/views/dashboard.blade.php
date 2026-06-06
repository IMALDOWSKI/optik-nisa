@extends('layouts.app')

@section('content')

{{-- Judul --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <span class="text-muted small">
        <i class="fas fa-calendar mr-1"></i>
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </span>
</div>

{{-- BARIS 1: Statistik --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Transaksi Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $transaksiHariIni }} Transaksi
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pendapatan Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Transaksi Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $transaksBulanIni }} Transaksi
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pendapatan Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 2: Grafik & Produk Terlaris --}}
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar"></i> Grafik Pendapatan 6 Bulan Terakhir
                </h6>
            </div>
            <div class="card-body">
                <canvas id="grafikPendapatan"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-trophy"></i> Produk Terlaris
                </h6>
            </div>
            <div class="card-body">
                @forelse($produkTerlaris as $p)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">{{ $p->nama_produk }}</span>
                        <span class="small font-weight-bold">{{ $p->total_terjual }} terjual</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success"
                             style="width: {{ ($p->total_terjual / max($produkTerlaris->max('total_terjual'), 1)) * 100 }}%">
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center mt-3">
                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                    Belum ada data
                </p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- BARIS 3: Transaksi Terbaru & Stok Menipis --}}
<div class="row">
    <div class="col-xl-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Transaksi Terbaru
                </h6>
                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $t)
                            <tr>
                                <td>
                                    <a href="{{ route('transaksi.show', $t) }}">
                                        <code>{{ $t->kode_transaksi }}</code>
                                    </a>
                                </td>
                                <td>{{ $t->pelanggan->nama }}</td>
                                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ ucfirst($t->metode_bayar) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                    Belum ada transaksi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle"></i> Stok Menipis
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Produk</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokMenipis as $s)
                            <tr>
                                <td>{{ $s->nama_produk }}</td>
                                <td>
                                    <span class="badge badge-{{ $s->stok == 0 ? 'danger' : 'warning' }}">
                                        {{ $s->stok }} unit
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">
                                    <i class="fas fa-check-circle text-success fa-2x d-block mb-2"></i>
                                    Semua stok aman!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikPendapatan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikLabel) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($grafikData) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush

@endsection