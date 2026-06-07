@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-truck mr-2"></i>Data Supplier
    </h1>
    <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Tambah Supplier
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Supplier</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Kontak Person</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $s)
                    <tr>
                        <td><code>{{ $s->kode_supplier }}</code></td>
                        <td>
                            <strong>{{ $s->nama }}</strong>
                            <br>
                            <small class="text-muted">{{ Str::limit($s->alamat, 40) }}</small>
                        </td>
                        <td>{{ $s->no_telepon }}</td>
                        <td>{{ $s->email ?? '-' }}</td>
                        <td>{{ $s->kontak_person ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $s->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($s->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('supplier.show', $s) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('supplier.edit', $s) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('supplier.destroy', $s) }}"
                                  method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus supplier ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-truck fa-2x mb-2 d-block"></i>
                            Belum ada data supplier
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $suppliers->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection