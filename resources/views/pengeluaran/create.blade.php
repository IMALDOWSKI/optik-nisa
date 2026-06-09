@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengeluaran</h1>
    <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('pengeluaran.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Judul <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Bayar listrik bulan Juni">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="kategori"
                                class="form-control @error('kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('kategori') == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Jumlah <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="jumlah"
                                   class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah') }}"
                                   placeholder="0" min="1">
                        </div>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Tanggal <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal"
                               class="form-control"
                               value="{{ old('tanggal', date('Y-m-d')) }}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control"
                                  rows="3" placeholder="Opsional...">{{ old('catatan') }}</textarea>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Simpan Pengeluaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-body">
                <h6 class="font-weight-bold text-info">
                    <i class="fas fa-info-circle mr-2"></i>Kategori Pengeluaran
                </h6>
                <ul class="list-unstyled mt-3">
                    @foreach(\App\Models\Pengeluaran::daftarKategori() as $k)
                    <li class="mb-2">{{ $k }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection