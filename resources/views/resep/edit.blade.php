@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Resep Mata</h1>
    <a href="{{ route('resep.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('resep.update', $resep) }}" method="POST">
            @csrf @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pelanggan <span class="text-danger">*</span></label>
                        <select name="pelanggan_id" class="form-control">
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ $resep->pelanggan_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Periksa <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_periksa" class="form-control" value="{{ $resep->tanggal_periksa }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <input type="text" name="dokter" class="form-control" value="{{ old('dokter', $resep->dokter) }}">
                    </div>
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
                            <td class="align-middle font-weight-bold text-primary">Kanan (OD)</td>
                            <td><input type="number" name="od_sph" step="0.25" class="form-control text-center" value="{{ old('od_sph', $resep->od_sph) }}"></td>
                            <td><input type="number" name="od_cyl" step="0.25" class="form-control text-center" value="{{ old('od_cyl', $resep->od_cyl) }}"></td>
                            <td><input type="number" name="od_axis" min="0" max="180" class="form-control text-center" value="{{ old('od_axis', $resep->od_axis) }}"></td>
                            <td><input type="number" name="od_add" step="0.25" class="form-control text-center" value="{{ old('od_add', $resep->od_add) }}"></td>
                            <td><input type="number" name="pd_kanan" step="0.5" class="form-control text-center" value="{{ old('pd_kanan', $resep->pd_kanan) }}"></td>
                        </tr>
                        <tr>
                            <td class="align-middle font-weight-bold text-success">Kiri (OS)</td>
                            <td><input type="number" name="os_sph" step="0.25" class="form-control text-center" value="{{ old('os_sph', $resep->os_sph) }}"></td>
                            <td><input type="number" name="os_cyl" step="0.25" class="form-control text-center" value="{{ old('os_cyl', $resep->os_cyl) }}"></td>
                            <td><input type="number" name="os_axis" min="0" max="180" class="form-control text-center" value="{{ old('os_axis', $resep->os_axis) }}"></td>
                            <td><input type="number" name="os_add" step="0.25" class="form-control text-center" value="{{ old('os_add', $resep->os_add) }}"></td>
                            <td><input type="number" name="pd_kiri" step="0.5" class="form-control text-center" value="{{ old('pd_kiri', $resep->pd_kiri) }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group mt-3">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $resep->catatan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Resep
            </button>
        </form>
    </div>
</div>
@endsection