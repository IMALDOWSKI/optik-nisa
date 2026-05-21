@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
    <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $i => $p)
                    <tr>
                        <td>{{ $produks->firstItem() + $i }}</td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>
                            <span class="badge badge-{{ $p->kategori == 'kacamata' ? 'primary' : ($p->kategori == 'lensa' ? 'success' : 'secondary') }}">
                                {{ ucfirst($p->kategori) }}
                            </span>
                        </td>
                        <td>{{ $p->merk ?? '-' }}</td>
                        <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ $p->stok > 10 ? 'success' : 'danger' }}">
                                {{ $p->stok }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('produk.edit', $p) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('produk.destroy', $p) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $produks->links() }}
    </div>
</div>
@endsection