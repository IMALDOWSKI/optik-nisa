@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Resep Mata</h1>
    <a href="{{ route('resep.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('resep.store') }}" method="POST">
            @csrf

            <!-- Info Umum -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pelanggan <span class="text-danger">*</span></label>
                        <select name="pelanggan_id" class="form-control @error('pelanggan_id') is-invalid @enderror">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pelanggan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Periksa <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_periksa" class="form-control" value="{{ old('tanggal_periksa', date('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <input type="text" name="dokter" class="form-control" value="{{ old('dokter') }}">
                    </div>
                </div>
            </div>

            <!-- Tabel Resep -->
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
                            <td><input type="number" name="od_sph" step="0.25" class="form-control text-center" value="{{ old('od_sph') }}" placeholder="0.00"></td>
                            <td><input type="number" name="od_cyl" step="0.25" class="form-control text-center" value="{{ old('od_cyl') }}" placeholder="0.00"></td>
                            <td><input type="number" name="od_axis" min="0" max="180" class="form-control text-center" value="{{ old('od_axis') }}" placeholder="0"></td>
                            <td><input type="number" name="od_add" step="0.25" class="form-control text-center" value="{{ old('od_add') }}" placeholder="0.00"></td>
                            <td><input type="number" name="pd_kanan" step="0.5" class="form-control text-center" value="{{ old('pd_kanan') }}" placeholder="0.0"></td>
                        </tr>
                        <tr>
                            <td class="align-middle font-weight-bold text-success">Kiri (OS)</td>
                            <td><input type="number" name="os_sph" step="0.25" class="form-control text-center" value="{{ old('os_sph') }}" placeholder="0.00"></td>
                            <td><input type="number" name="os_cyl" step="0.25" class="form-control text-center" value="{{ old('os_cyl') }}" placeholder="0.00"></td>
                            <td><input type="number" name="os_axis" min="0" max="180" class="form-control text-center" value="{{ old('os_axis') }}" placeholder="0"></td>
                            <td><input type="number" name="os_add" step="0.25" class="form-control text-center" value="{{ old('os_add') }}" placeholder="0.00"></td>
                            <td><input type="number" name="pd_kiri" step="0.5" class="form-control text-center" value="{{ old('pd_kiri') }}" placeholder="0.0"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group mt-3">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Resep
            </button>
        </form>
    </div>
</div>
@endsection