@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Riwayat Pelanggan
    </h1>
    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

{{-- Info Pelanggan --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-auto">
                <div style="width:70px; height:70px;
                            background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
                            border-radius: 50%; display:flex; align-items:center;
                            justify-content:center; font-size:1.8rem;
                            color:white; font-weight:bold;">
                    {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
                </div>
            </div>
            <div class="col">
                <h4 class="font-weight-bold mb-1">{{ $pelanggan->nama }}</h4>
                <p class="text-muted mb-0">
                    <i class="fas fa-phone mr-1"></i>{{ $pelanggan->no_telepon }}
                    @if($pelanggan->email)
                        &nbsp;|&nbsp;
                        <i class="fas fa-envelope mr-1"></i>{{ $pelanggan->email }}
                    @endif
                </p>
                <p class="text-muted mb-0">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $pelanggan->alamat }}
                </p>
            </div>
            <div class="col-auto text-right">
                <div class="row">
                    <div class="col-6">
                        <div class="card border-left-primary py-2 px-3">
                            <div class="text-xs text-primary font-weight-bold">Total Transaksi</div>
                            <div class="h5 font-weight-bold mb-0">{{ $transaksis->count() }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-left-success py-2 px-3">
                            <div class="text-xs text-success font-weight-bold">Total Belanja</div>
                            <div class="h5 font-weight-bold mb-0">
                                Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- Riwayat Resep Mata --}}
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-eye mr-2"></i>Riwayat Resep Mata
                </h6>
                <a href="{{ route('resep.create') }}?pelanggan_id={{ $pelanggan->id }}"
                   class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($resepMatas as $r)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between mb-2">
                        <strong class="text-primary">
                            {{ \Carbon\Carbon::parse($r->tanggal_periksa)->format('d/m/Y') }}
                        </strong>
                        @if($r->dokter)
                            <small class="text-muted">dr. {{ $r->dokter }}</small>
                        @endif
                    </div>
                    <table class="table table-sm table-bordered mb-0 text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Mata</th>
                                <th>SPH</th>
                                <th>CYL</th>
                                <th>AXIS</th>
                                <th>PD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-primary font-weight-bold">OD</td>
                                <td>{{ $r->formatNilai($r->od_sph) }}</td>
                                <td>{{ $r->formatNilai($r->od_cyl) }}</td>
                                <td>{{ $r->od_axis ?? '-' }}</td>
                                <td>{{ $r->pd_kanan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-success font-weight-bold">OS</td>
                                <td>{{ $r->formatNilai($r->os_sph) }}</td>
                                <td>{{ $r->formatNilai($r->os_cyl) }}</td>
                                <td>{{ $r->os_axis ?? '-' }}</td>
                                <td>{{ $r->pd_kiri ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($r->catatan)
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-sticky-note mr-1"></i>{{ $r->catatan }}
                        </small>
                    @endif
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-eye-slash fa-2x mb-2 d-block"></i>
                    Belum ada data resep mata
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shopping-cart mr-2"></i>Riwayat Transaksi
                </h6>
                <a href="{{ route('transaksi.create') }}"
                   class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Transaksi Baru
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($transaksis as $t)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <code class="text-primary">{{ $t->kode_transaksi }}</code>
                            <span class="badge badge-{{ $t->status == 'selesai' ? 'success' : 'warning' }} ml-1">
                                {{ ucfirst($t->status) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <strong>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                    <div>
                        @foreach($t->details as $d)
                            <span class="badge badge-light border mr-1 mb-1">
                                {{ $d->produk->nama_produk }} ({{ $d->jumlah }}x)
                            </span>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('transaksi.show', $t) }}"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('transaksi.struk', $t) }}"
                           class="btn btn-success btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Struk
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    Belum ada riwayat transaksi
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection