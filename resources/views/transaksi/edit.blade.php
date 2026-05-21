@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Transaksi</h1>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Pelanggan</label>
                <select name="pelanggan_id" class="form-control @error('pelanggan_id') is-invalid @enderror">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $p)
                        <option value="{{ $p->id }}" {{ old('pelanggan_id', $transaksi->pelanggan_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pelanggan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Produk</label>
                <select name="produk_id" class="form-control @error('produk_id') is-invalid @enderror" id="produkSelect">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $p)
                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}" {{ old('produk_id', $transaksi->produk_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('produk_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" id="jumlahInput" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $transaksi->jumlah) }}" min="1">
                @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Total Harga (otomatis)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" id="totalHarga" class="form-control" readonly value="{{ number_format($transaksi->total_harga, 0, ',', '.') }}">
                </div>
            </div>
            <div class="form-group">
                <label>Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}">
                @error('tanggal_transaksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="pending" {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status', $transaksi->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $transaksi->catatan) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function hitungTotal() {
        const select = document.getElementById('produkSelect');
        const jumlah = document.getElementById('jumlahInput').value;
        const harga  = select.options[select.selectedIndex]?.dataset.harga || 0;
        const total  = harga * jumlah;
        document.getElementById('totalHarga').value = total.toLocaleString('id-ID');
    }
    document.getElementById('produkSelect').addEventListener('change', hitungTotal);
    document.getElementById('jumlahInput').addEventListener('input', hitungTotal);
</script>
@endpush
@endsection