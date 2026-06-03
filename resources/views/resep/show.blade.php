@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Resep Mata</h1>
    <a href="{{ route('resep.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            {{ $resep->pelanggan->nama }} —
            {{ \Carbon\Carbon::parse($resep->tanggal_periksa)->format('d/m/Y') }}
        </h6>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Pelanggan:</strong> {{ $resep->pelanggan->nama }}
            </div>
            <div class="col-md-4">
                <strong>Tanggal Periksa:</strong> {{ \Carbon\Carbon::parse($resep->tanggal_periksa)->format('d/m/Y') }}
            </div>
            <div class="col-md-4">
                <strong>Dokter:</strong> {{ $resep->dokter ?? '-' }}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Mata</th>
                        <th>SPH</th>
                        <th>CYL</th>
                        <th>AXIS</th>
                        <th>ADD</th>
                        <th>PD</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold text-primary">Kanan (OD)</td>
                        <td>{{ $resep->formatNilai($resep->od_sph) }}</td>
                        <td>{{ $resep->formatNilai($resep->od_cyl) }}</td>
                        <td>{{ $resep->od_axis ?? '-' }}</td>
                        <td>{{ $resep->formatNilai($resep->od_add) }}</td>
                        <td>{{ $resep->pd_kanan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-success">Kiri (OS)</td>
                        <td>{{ $resep->formatNilai($resep->os_sph) }}</td>
                        <td>{{ $resep->formatNilai($resep->os_cyl) }}</td>
                        <td>{{ $resep->os_axis ?? '-' }}</td>
                        <td>{{ $resep->formatNilai($resep->os_add) }}</td>
                        <td>{{ $resep->pd_kiri ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($resep->catatan)
        <p class="mt-3"><strong>Catatan:</strong> {{ $resep->catatan }}</p>
        @endif

        <hr>
        <a href="{{ route('resep.edit', $resep) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>
@endsection