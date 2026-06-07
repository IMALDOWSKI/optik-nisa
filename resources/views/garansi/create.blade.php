@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Garansi</h1>
    <a href="{{ route('garansi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-shield-alt mr-2"></i>Form Garansi Produk
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ route('garansi.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Transaksi <span class="text-danger">*</span>
                        </label>
                        <select name="transaksi_id" id="transaksiSelect"
                                class="form-control @error('transaksi_id') is-invalid @enderror">
                            <option value="">-- Pilih Transaksi --</option>
                            @foreach($transaksis as $t)
                                <option value="{{ $t->id }}"
                                    data-pelanggan="{{ $t->pelanggan_id }}"
                                    {{ old('transaksi_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->kode_transaksi }} -
                                    {{ $t->pelanggan->nama }} -
                                    {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('transaksi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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
                                    {{ $p->nama }}
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
                            Produk <span class="text-danger">*</span>
                        </label>
                        <select name="produk_id"
                                class="form-control @error('produk_id') is-invalid @enderror">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produks as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('produk_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                        @error('produk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Tanggal Mulai <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai"
                               class="form-control"
                               value="{{ old('tanggal_mulai', date('Y-m-d')) }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Tanggal Selesai <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_selesai"
                               class="form-control"
                               value="{{ old('tanggal_selesai') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Ketentuan Garansi</label>
                        <textarea name="ketentuan" class="form-control" rows="3"
                                  placeholder="Contoh: Garansi kerusakan bahan frame selama 1 tahun, tidak termasuk kerusakan akibat kelalaian pengguna">{{ old('ketentuan') }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Simpan Garansi
            </button>
        </form>
    </div>
</div>
@endsection