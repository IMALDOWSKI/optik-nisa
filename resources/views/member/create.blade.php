@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftarkan Member Baru</h1>
    <a href="{{ route('member.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('member.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Pilih Pelanggan <span class="text-danger">*</span>
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
                        <small class="text-muted">
                            Hanya menampilkan pelanggan yang belum terdaftar sebagai member
                        </small>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-id-card mr-2"></i>Daftarkan Member
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-body">
                <h6 class="font-weight-bold text-info">
                    <i class="fas fa-info-circle mr-2"></i>Ketentuan Member
                </h6>
                <ul class="mt-3">
                    <li class="mb-2">
                        <strong>Poin:</strong> Setiap Rp 10.000 transaksi = 1 poin
                    </li>
                    <li class="mb-2">
                        <strong>Nilai Poin:</strong> 1 poin = Rp 1.000 diskon
                    </li>
                    <li class="mb-2">
                        <strong>🥈 Silver:</strong> 0 - 499 poin
                    </li>
                    <li class="mb-2">
                        <strong>🥇 Gold:</strong> 500 - 999 poin
                    </li>
                    <li class="mb-2">
                        <strong>💎 Platinum:</strong> 1000+ poin
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection