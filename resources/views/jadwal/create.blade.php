@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Jadwal Booking</h1>
    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Pelanggan <span class="text-danger">*</span>
                        </label>
                        <select name="pelanggan_id"
                                class="form-control @error('pelanggan_id') is-invalid @enderror">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} — {{ $p->no_telepon }}
                                </option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Jenis Booking <span class="text-danger">*</span>
                        </label>
                        <select name="jenis"
                                class="form-control @error('jenis') is-invalid @enderror">
                            <option value="kontrol_mata">👁️ Kontrol Mata</option>
                            <option value="ambil_kacamata">👓 Ambil Kacamata</option>
                            <option value="konsultasi">💬 Konsultasi</option>
                            <option value="lainnya">📌 Lainnya</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Tanggal <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal"
                               class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}">
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Jam <span class="text-danger">*</span>
                        </label>
                        <input type="time" name="jam"
                               class="form-control @error('jam') is-invalid @enderror"
                               value="{{ old('jam', '09:00') }}">
                        @error('jam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  placeholder="Contoh: Booking via telepon, minta konsultasi lensa progresif">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Simpan Jadwal
            </button>
        </form>
    </div>
</div>
@endsection