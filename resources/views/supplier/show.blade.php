@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Supplier</h1>
    <div>
        <a href="{{ route('supplier.edit', $supplier) }}"
           class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-truck mr-2"></i>Informasi Supplier
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted">Kode</td>
                        <td><code>{{ $supplier->kode_supplier }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama</td>
                        <td><strong>{{ $supplier->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. Telepon</td>
                        <td>{{ $supplier->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email</td>
                        <td>{{ $supplier->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kontak Person</td>
                        <td>{{ $supplier->kontak_person ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Alamat</td>
                        <td>{{ $supplier->alamat }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge badge-{{ $supplier->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($supplier->status) }}
                            </span>
                        </td>
                    </tr>
                    @if($supplier->catatan)
                    <tr>
                        <td class="text-muted">Catatan</td>
                        <td>{{ $supplier->catatan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history mr-2"></i>Riwayat Restok dari Supplier Ini
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                <th>No. Faktur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($restoks as $r)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($r->tanggal_restok)->format('d/m/Y') }}</td>
                                <td>{{ $r->produk->nama_produk }}</td>
                                <td>
                                    <span class="badge badge-success">+{{ $r->jumlah_tambah }}</span>
                                </td>
                                <td>
                                    @if($r->harga_beli)
                                        Rp {{ number_format($r->harga_beli, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $r->no_faktur ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada riwayat restok
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
@endsection