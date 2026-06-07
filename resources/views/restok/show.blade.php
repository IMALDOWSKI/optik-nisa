@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Restok</h1>
    <a href="{{ route('restok.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-box mr-2"></i>Informasi Restok
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%" class="text-muted">Produk</td>
                        <td><strong>{{ $restok->produk->nama_produk }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kode Produk</td>
                        <td><code>{{ $restok->produk->kode_produk }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Restok</td>
                        <td>{{ \Carbon\Carbon::parse($restok->tanggal_restok)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jumlah Tambah</td>
                        <td>
                            <span class="badge badge-success">+{{ $restok->jumlah_tambah }} unit</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Stok Sebelum</td>
                        <td>{{ $restok->stok_sebelum }} unit</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Stok Sesudah</td>
                        <td><span class="badge badge-primary">{{ $restok->stok_sesudah }} unit</span></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%" class="text-muted">Supplier</td>
                        <td>{{ $restok->supplier ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. Faktur</td>
                        <td>{{ $restok->no_faktur ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Harga Beli</td>
                        <td>
                            @if($restok->harga_beli)
                                Rp {{ number_format($restok->harga_beli, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dicatat Oleh</td>
                        <td>{{ $restok->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Catatan</td>
                        <td>{{ $restok->catatan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection