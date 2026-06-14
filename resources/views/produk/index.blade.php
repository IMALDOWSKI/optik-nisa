@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
    <div>
        <a href="{{ route('produk.barcode.massal') }}"
           class="btn btn-secondary btn-sm shadow-sm mr-2" target="_blank">
            <i class="fas fa-barcode mr-1"></i>Cetak Barcode Massal
        </a>
        <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk
        </a>
    </div>
</div>

<!-- Filter Kategori -->
<div class="card shadow mb-3">
    <div class="card-body py-2">
        <a href="{{ route('produk.index') }}" 
           class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-outline-primary' }}">
           Semua
        </a>
        <a href="{{ route('produk.index', ['kategori' => 'kacamata']) }}" 
           class="btn btn-sm {{ request('kategori') == 'kacamata' ? 'btn-primary' : 'btn-outline-primary' }}">
           Frame
        </a>
        <a href="{{ route('produk.index', ['kategori' => 'lensa']) }}" 
           class="btn btn-sm {{ request('kategori') == 'lensa' ? 'btn-success' : 'btn-outline-success' }}">
           Lensa
        </a>
        <a href="{{ route('produk.index', ['kategori' => 'aksesoris']) }}" 
           class="btn btn-sm {{ request('kategori') == 'aksesoris' ? 'btn-secondary' : 'btn-outline-secondary' }}">
           Aksesoris
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $p)
                    <tr>
                        <td><code>{{ $p->kode_produk }}</code></td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>
                            <span class="badge badge-{{ $p->kategori == 'kacamata' ? 'primary' : ($p->kategori == 'lensa' ? 'success' : 'secondary') }}">
                                {{ ucfirst($p->kategori) }}
                            </span>
                        </td>
                        <td>{{ $p->merk ?? '-' }}</td>
                        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ $p->stok > 10 ? 'success' : ($p->stok > 0 ? 'warning' : 'danger') }}">
                                {{ $p->stok }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $p->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('produk.show', $p) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('produk.edit', $p) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('cetak.barcode.produk', $p) }}"
   class="btn btn-secondary btn-sm" title="Cetak Barcode"
   target="_blank">
    <i class="fas fa-barcode"></i>
</a>
                            <form action="{{ route('produk.destroy', $p) }}"
                                  method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $produks->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection