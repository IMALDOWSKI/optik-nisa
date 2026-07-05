@extends('layouts.app')

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner mb-4">
    <div class="welcome-content">
        <div class="welcome-text">
            <h2>
                {{ __('menu.selamat_datang') }},
                <strong>{{ auth()->user()->name }}</strong>! 👋
            </h2>
            <p>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} —
                Berikut ringkasan aktivitas toko hari ini.
            </p>
        </div>
        <div class="welcome-icon">👓</div>
    </div>
</div>

{{-- BARIS 1: Statistik Hari Ini --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            {{ __('menu.transaksi_hari_ini') }}
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
        <div class="card stat-card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            {{ __('menu.pendapatan_hari_ini') }}
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
        <div class="card stat-card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            {{ __('menu.transaksi_bulan_ini') }}

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
        <div class="card stat-card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            {{ __('menu.pendapatan_bulan_ini') }}
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

{{-- BARIS 2: Statistik Tambahan --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            {{ __('menu.total_pelanggan') }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalPelanggan }}
                            <small class="text-success small">
                                +{{ $pelangganBaru }} bulan ini
                            </small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            {{ __('menu.total_pendapatan') }}

                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            {{ __('menu.total_diskon_diberikan') }}

                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalDiskon, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            {{ __('menu.garansi_hampir_expired') }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $garansiHampirExpired->count() }} Garansi
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 3: Grafik --}}
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar mr-2"></i>Grafik Pendapatan 6 Bulan Terakhir
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
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-credit-card mr-2"></i>Metode Pembayaran Bulan Ini
                </h6>
            </div>
            <div class="card-body">
                <canvas id="grafikMetodeBayar"></canvas>
                <div class="mt-3">
                    @foreach($metodeBayarData as $m)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">{{ ucfirst($m->metode_bayar) }}</span>
                        <span class="small font-weight-bold">{{ $m->total }} transaksi</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 4: Kategori & Produk Terlaris --}}
<div class="row">
    <div class="col-xl-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie mr-2"></i>Penjualan per Kategori
                </h6>
            </div>
            <div class="card-body">
                <canvas id="grafikKategori"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-trophy mr-2"></i>Produk Terlaris
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Terjual</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produkTerlaris as $i => $p)
                            <tr>
                                <td>
                                    @if($i == 0) 🥇
                                    @elseif($i == 1) 🥈
                                    @elseif($i == 2) 🥉
                                    @else {{ $i + 1 }}
                                    @endif
                                </td>
                                <td>{{ $p->nama_produk }}</td>
                                <td>
                                    <span class="badge badge-{{
                                        $p->kategori == 'kacamata' ? 'primary' :
                                        ($p->kategori == 'lensa' ? 'success' : 'secondary')
                                    }}">
                                        {{ ucfirst($p->kategori) }}
                                    </span>
                                </td>
                                <td>{{ $p->total_terjual }} unit</td>
                                <td>Rp {{ number_format($p->total_pendapatan, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-box-open fa-2x text-gray-300 d-block mb-2"></i>
                                    <span class="text-muted">Belum ada data penjualan</span>
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

{{-- BARIS 5: Transaksi Terbaru & Stok Menipis --}}
<div class="row">
    <div class="col-xl-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Transaksi Terbaru
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
                                <td>Rp {{ number_format($t->grand_total ?? $t->total_harga, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-receipt fa-2x text-gray-300 d-block mb-2"></i>
                                    <span class="text-muted">{{ __('menu.belum_ada_transaksi') }}</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Stok Menipis
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Produk</th>
                                <th>Stok</th>
                                <th>Aksi</th>
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
                                <td>
                                    <a href="{{ route('restok.create') }}"
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Restok
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-2x text-success d-block mb-2"></i>
                                    <span class="text-muted">Semua stok aman!</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($garansiHampirExpired->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-shield-alt mr-2"></i>Garansi Hampir Expired
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($garansiHampirExpired as $g)
                            <tr>
                                <td>{{ $g->pelanggan->nama }}</td>
                                <td>{{ $g->produk->nama_produk }}</td>
                                <td>
                                    <span class="badge badge-warning">
                                        {{ $g->sisaHari() }} hari
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<style>
    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, #1a3a5c 0%, #2d5f8a 50%, #00b4d8 100%);
        border-radius: 16px;
        padding: 28px 35px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(26,58,92,0.25);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -60%;
        right: 15%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .welcome-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 1;
    }

    .welcome-text h2 {
        font-size: 1.6rem;
        margin-bottom: 6px;
        color: white !important;
    }

    .welcome-text p {
        opacity: 0.8;
        font-size: 0.9rem;
        margin: 0;
    }

    .welcome-icon {
        font-size: 60px;
        opacity: 0.3;
        animation: floatIcon 3s ease-in-out infinite;
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-8px); }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Pendapatan
    new Chart(document.getElementById('grafikPendapatan').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikLabel) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($grafikData) !!},
                backgroundColor: 'rgba(26, 58, 92, 0.6)',
                borderColor: 'rgba(26, 58, 92, 1)',
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

    // Grafik Metode Bayar
    const metodeBayar = @json($metodeBayarData);
    new Chart(document.getElementById('grafikMetodeBayar').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: metodeBayar.map(m => m.metode_bayar.charAt(0).toUpperCase() + m.metode_bayar.slice(1)),
            datasets: [{
                data: metodeBayar.map(m => m.total),
                backgroundColor: ['#1a3a5c', '#00b4d8', '#f6a623'],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Grafik Kategori
    const kategori = @json($kategoriData);
    new Chart(document.getElementById('grafikKategori').getContext('2d'), {
        type: 'pie',
        data: {
            labels: kategori.map(k => k.kategori.charAt(0).toUpperCase() + k.kategori.slice(1)),
            datasets: [{
                data: kategori.map(k => k.total),
                backgroundColor: ['#1a3a5c', '#00b4d8', '#f6a623', '#2d5f8a'],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // ===== ANIMASI STAT CARDS =====
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, i * 100);
    });
</script>
@endpush