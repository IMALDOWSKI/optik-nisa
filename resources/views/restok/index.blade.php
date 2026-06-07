@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-boxes mr-2"></i>Riwayat Restok
    </h1>
    <a href="{{ route('restok.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Tambah Restok
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Supplier</th>
                        <th>No. Faktur</th>
                        <th>Tambah</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Harga Beli</th>
                        <th>Dicatat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restoks as $r)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_restok)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $r->produk->nama_produk }}</strong>
                            <br>
                            <small class="text-muted">{{ $r->produk->kode_produk }}</small>
                        </td>
                        <td>{{ $r->supplier ?? '-' }}</td>
                        <td>{{ $r->no_faktur ?? '-' }}</td>
                        <td>
                            <span class="badge badge-success">+{{ $r->jumlah_tambah }}</span>
                        </td>
                        <td>{{ $r->stok_sebelum }}</td>
                        <td>
                            <span class="badge badge-primary">{{ $r->stok_sesudah }}</span>
                        </td>
                        <td>
                            @if($r->harga_beli)
                                Rp {{ number_format($r->harga_beli, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $r->user->name }}</td>
                        <td>
                            <a href="{{ route('restok.show', $r) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data restok
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $restoks->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection