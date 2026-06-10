@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Produk</h1>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">{{ $produk->nama_produk }}</h6>
        <code>{{ $produk->kode_produk }}</code>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th width="40%">Kategori</th><td>
                        <span class="badge badge-{{ $produk->kategori == 'kacamata' ? 'primary' : ($produk->kategori == 'lensa' ? 'success' : 'secondary') }}">
                            {{ ucfirst($produk->kategori) }}
                        </span>
                    </td></tr>
                    <tr><th>Merk</th><td>{{ $produk->merk ?? '-' }}</td></tr>
                    <tr><th>Harga</th><td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td></tr>
                    <tr><th>Stok</th><td>
                        <span class="badge badge-{{ $produk->stok > 10 ? 'success' : ($produk->stok > 0 ? 'warning' : 'danger') }}">
                            {{ $produk->stok }} unit
                        </span>
                    </td></tr>
                    <tr><th>Status</th><td>
                        <span class="badge badge-{{ $produk->status == 'aktif' ? 'success' : 'danger' }}">
                            {{ ucfirst($produk->status) }}
                        </span>
                    </td></tr>
                    <tr>
    <th>Barcode</th>
    <td>
        @if($produk->barcode)
            <code>{{ $produk->barcode }}</code>
            <div id="barcodeDisplay" class="mt-2"></div>
        @else
            <span class="text-muted">Belum ada barcode</span>
            <a href="{{ route('produk.edit', $produk) }}" class="btn btn-xs btn-warning ml-2">
                <i class="fas fa-plus"></i> Tambah
            </a>
        @endif
    </td>
</tr>
                </table>
            </div>
            <div class="col-md-6">
                @if($produk->kategori == 'kacamata')
                <h6 class="font-weight-bold text-primary">Detail Frame</h6>
                <table class="table table-borderless">
                    <tr><th width="40%">Material</th><td>{{ $produk->material ?? '-' }}</td></tr>
                    <tr><th>Ukuran</th><td>{{ $produk->ukuran ?? '-' }}</td></tr>
                    <tr><th>Warna</th><td>{{ $produk->warna ?? '-' }}</td></tr>
                    <tr><th>Gender</th><td>{{ ucfirst($produk->gender ?? '-') }}</td></tr>
                </table>
                @elseif($produk->kategori == 'lensa')
                <h6 class="font-weight-bold text-success">Detail Lensa</h6>
                <table class="table table-borderless">
                    <tr><th width="40%">Jenis</th><td>{{ $produk->jenis_lensa ?? '-' }}</td></tr>
                    <tr><th>Indeks</th><td>{{ $produk->indeks_lensa ?? '-' }}</td></tr>
                    <tr><th>Coating</th><td>{{ $produk->coating ?? '-' }}</td></tr>
                </table>
                @endif
            </div>
        </div>
        @if($produk->deskripsi)
        <hr>
        <p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
        @endif

        <hr>
        <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>
@endsection