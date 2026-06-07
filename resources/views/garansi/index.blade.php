@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-shield-alt mr-2"></i>Manajemen Garansi
    </h1>
    <a href="{{ route('garansi.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Tambah Garansi
    </a>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Garansi Aktif
                </div>
                <div class="h5 font-weight-bold text-gray-800">{{ $totalAktif }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Garansi Diklaim
                </div>
                <div class="h5 font-weight-bold text-gray-800">{{ $totalKlaim }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Garansi Expired
                </div>
                <div class="h5 font-weight-bold text-gray-800">{{ $totalExpired }}</div>
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
                        <th>No. Garansi</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Sisa Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($garansis as $g)
                    <tr>
                        <td><code>{{ $g->no_garansi }}</code></td>
                        <td>{{ $g->pelanggan->nama }}</td>
                        <td>{{ $g->produk->nama_produk }}</td>
                        <td>{{ \Carbon\Carbon::parse($g->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($g->tanggal_selesai)->format('d/m/Y') }}</td>
                        <td>
                            @if($g->status == 'aktif')
                                @php $sisa = $g->sisaHari(); @endphp
                                <span class="badge badge-{{ $sisa <= 7 ? 'warning' : 'success' }}">
                                    {{ $sisa }} hari
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{
                                $g->status == 'aktif' ? 'success' :
                                ($g->status == 'klaim' ? 'warning' : 'danger')
                            }}">
                                {{ ucfirst($g->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('garansi.show', $g) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-shield-alt fa-2x mb-2 d-block"></i>
                            Belum ada data garansi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $garansis->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection