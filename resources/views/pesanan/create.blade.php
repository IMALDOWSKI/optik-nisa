@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Pesanan Baru</h1>
    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('pesanan.store') }}" method="POST">
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
                        <label class="font-weight-bold">Estimasi Selesai</label>
                        <input type="date" name="tanggal_estimasi"
                               class="form-control"
                               value="{{ old('tanggal_estimasi') }}">
                        <small class="text-muted">
                            Kapan perkiraan kacamata selesai dibuat
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan untuk Pelanggan</label>
                        <textarea name="catatan" class="form-control" rows="2"
                                  placeholder="Contoh: Lensa dipesan dari Jakarta">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan Internal</label>
                        <textarea name="catatan_internal" class="form-control" rows="2"
                                  placeholder="Catatan hanya untuk staff (tidak terlihat pelanggan)">{{ old('catatan_internal') }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Buat Pesanan
            </button>
        </form>
    </div>
</div>
@endsection