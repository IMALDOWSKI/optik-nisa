@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-cog mr-2"></i>Pengaturan Toko
    </h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-store mr-2"></i>Informasi Toko
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Toko</label>
                        <input type="text" name="nama_toko"
                               class="form-control @error('nama_toko') is-invalid @enderror"
                               value="{{ old('nama_toko', $namaToko) }}">
                        @error('nama_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Alamat Toko</label>
                        <textarea name="alamat_toko" class="form-control" rows="2">{{ old('alamat_toko', $alamatToko) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">No. Telepon Toko</label>
                        <input type="text" name="telepon_toko"
                               class="form-control"
                               value="{{ old('telepon_toko', $teleponToko) }}">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="font-weight-bold">
                            QR Code QRIS / E-Wallet
                        </label>
                        <input type="file" name="qris_image"
                               class="form-control-file @error('qris_image') is-invalid @enderror"
                               accept="image/*">
                        @error('qris_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            Upload gambar QR Code (QRIS, DANA, OVO, GoPay, dll). Format: JPG/PNG, maks 2MB.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-qrcode mr-2"></i>Preview QR Code
                </h6>
            </div>
            <div class="card-body text-center">
                @if($qrisImage)
                    <img src="{{ asset('storage/' . $qrisImage) }}"
                         alt="QRIS"
                         class="img-fluid mb-3"
                         style="max-width: 300px; border: 1px solid #ddd; border-radius: 8px; padding: 10px;">
                    <br>
                    <form action="{{ route('pengaturan.qris.hapus') }}" method="POST"
                          onsubmit="return confirm('Yakin hapus QR Code ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash mr-1"></i>Hapus QR Code
                        </button>
                    </form>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-qrcode fa-4x mb-3 d-block"></i>
                        <p>Belum ada QR Code yang diupload</p>
                        <small>Upload QR Code di form sebelah kiri agar bisa digunakan saat transaksi pembayaran QRIS</small>
                    </div>
                @endif
            </div>
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Cara Kerja QRIS Manual:</strong>
            <ol class="mb-0 mt-2">
                <li>Upload QR Code dari rekening QRIS / DANA / OVO / GoPay toko</li>
                <li>Saat kasir pilih metode bayar <strong>QRIS</strong>, QR Code akan muncul</li>
                <li>Pelanggan scan & bayar melalui HP mereka</li>
                <li>Kasir konfirmasi pembayaran setelah notifikasi masuk</li>
            </ol>
        </div>
    </div>
</div>
@endsection