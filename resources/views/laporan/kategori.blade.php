@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tags mr-2"></i>{{ __('menu.laporan_per_kategori') }}
    </h1>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.kategori') }}" class="form-inline">
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">{{ __('menu.bulan') }}:</label>

                <select name="bulan" class="form-control">
                    @foreach($daftarBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
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
                <i class="fas fa-search"></i> {{ __('menu.filter') }}
            </button>
        </form>
    </div>
</div>

{{-- Ringkasan per Kategori --}}
<div class="row mb-4">
    @foreach($data as $d)
    <div class="col-md-4">
        <div class="card border-left-{{ $d->kategori == 'kacamata' ? 'primary' : ($d->kategori == 'lensa' ? 'success' : 'secondary') }} shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1
                    {{ $d->kategori == 'kacamata' ? 'text-primary' : ($d->kategori == 'lensa' ? 'text-success' : 'text-secondary') }}">
                    {{ ucfirst($d->kategori) }}
                </div>
                <div class="row no-gutters align-items-center">
                    <div class="col">
                <div class="h5 font-weight-bold text-gray-800 mb-0">
                            Rp {{ number_format($d->total_pendapatan, 0, ',', '.') }}
                        </div>
                        <small class="text-muted">
                            {{ $d->total_terjual }} {{ __('menu.unit_terjual') }} |
                            {{ $d->total_transaksi }} {{ __('menu.transaksi') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Detail per Produk --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('menu.detail_per_produk') }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Total Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detailProduk as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><code>{{ $p->kode_produk }}</code></td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>
                            <span class="badge badge-{{ $p->kategori == 'kacamata' ? 'primary' : ($p->kategori == 'lensa' ? 'success' : 'secondary') }}">
                                {{ ucfirst($p->kategori) }}
                            </span>
                        </td>
                        <td>{{ $p->total_terjual }} unit</td>
                        <td>Rp {{ number_format($p->total_pendapatan, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            {{ __('menu.belum_ada_data_periode') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection