@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pelanggan
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggans as $i => $p)
                    <tr>
                        <td>{{ $pelanggans->firstItem() + $i }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>{{ $p->email ?? '-' }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>
                            <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" style="display:inline">
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
        {{ $pelanggans->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection