@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Resep Mata</h1>
    <a href="{{ route('resep.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Resep
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Pelanggan</th>
                        <th>Tgl Periksa</th>
                        <th colspan="4" class="text-center">Mata Kanan (OD)</th>
                        <th colspan="4" class="text-center">Mata Kiri (OS)</th>
                        <th>PD</th>
                        <th>Dokter</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>SPH</th><th>CYL</th><th>AXIS</th><th>ADD</th>
                        <th>SPH</th><th>CYL</th><th>AXIS</th><th>ADD</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reseps as $r)
                    <tr>
                        <td>{{ $r->pelanggan->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal_periksa)->format('d/m/Y') }}</td>
                        <td>{{ $r->formatNilai($r->od_sph) }}</td>
                        <td>{{ $r->formatNilai($r->od_cyl) }}</td>
                        <td>{{ $r->od_axis ?? '-' }}</td>
                        <td>{{ $r->formatNilai($r->od_add) }}</td>
                        <td>{{ $r->formatNilai($r->os_sph) }}</td>
                        <td>{{ $r->formatNilai($r->os_cyl) }}</td>
                        <td>{{ $r->os_axis ?? '-' }}</td>
                        <td>{{ $r->formatNilai($r->os_add) }}</td>
                        <td>{{ $r->pd_kanan ?? '-' }}/{{ $r->pd_kiri ?? '-' }}</td>
                        <td>{{ $r->dokter ?? '-' }}</td>
                        <td>
                            <a href="{{ route('resep.show', $r) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('resep.edit', $r) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('resep.destroy', $r) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus resep ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $reseps->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection