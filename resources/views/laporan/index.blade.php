@extends('layouts.app')

@section('content')

{{-- Judul & Tombol Export --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('menu.laporan_transaksi') }}</h1>
    <div>
        <a href="{{ route('laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="btn btn-danger btn-sm shadow-sm mr-2" target="_blank">

        <i class="fas fa-file-pdf"></i> {{ __('menu.export_pdf') }}
    </a>
<a href="{{ route('laporan.csv', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
   class="btn btn-success btn-sm shadow-sm" target="_blank">
    <i class="fas fa-file-excel"></i> {{ __('menu.export_excel') }}
</a>
        <a href="{{ route('laporan.print', ['bulan' => $bulan, 'tahun' => $tahun, 'status' => $status]) }}"
   target="_blank" class="btn btn-secondary btn-sm">
    <i class="fas fa-print mr-1"></i>{{ __('menu.print_browser') }}
</a>
    </div>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.index') }}" class="form-inline">
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
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">{{ __('menu.status') }}:</label>
                <select name="status" class="form-control">
                    <option value="">{{ __('menu.semua') }}</option>
                    <option value="selesai"    {{ $status == 'selesai'    ? 'selected' : '' }}>{{ __('menu.selesai') }}</option>
                    <option value="pending"    {{ $status == 'pending'    ? 'selected' : '' }}>{{ __('menu.pending') }}</option>
                    <option value="dibatalkan" {{ $status == 'dibatalkan' ? 'selected' : '' }}>{{ __('menu.dibatalkan') }}</option>

                </select>
            </div>
                <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> {{ __('menu.filter') }}
            </button>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    {{ __('menu.total_transaksi') }}
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $transaksis->count() }} {{ __('menu.transaksi') }}
                </div>
            </div>
        </div>
    </div>
<div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    {{ __('menu.total_pendapatan') }}
                </div>

                <div class="h5 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    {{ __('menu.periode') }}
                </div>

                <div class="h5 font-weight-bold text-gray-800">
                    {{ $daftarBulan[$bulan] }} {{ $tahun }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><code>{{ $t->kode_transaksi }}</code></td>
                        <td>{{ $t->pelanggan->nama }}</td>
                        <td>
    @foreach($t->details as $d)
        <small class="d-block">{{ $d->is_frame_sendiri ? 'Frame Milik Pelanggan' : ($d->produk->nama_produk ?? '-') }}</small>
    @endforeach
</td>
                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ ucfirst($t->metode_bayar) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $t->status == 'selesai' ? 'success' : ($t->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            {{ __('menu.empty_laporan_transaksi') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transaksis->count() > 0)
                <tfoot>
                    <tr class="bg-light font-weight-bold">
                        <td colspan="4" class="text-right">{{ __('menu.total_pendapatan') }}:</td>
                        <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection