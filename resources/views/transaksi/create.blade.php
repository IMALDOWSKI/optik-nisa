@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Transaksi</h1>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
<div class="form-group">
    <label>Pelanggan <span class="text-danger">*</span></label>
    <div class="input-group">
        <select name="pelanggan_id" id="pelangganSelect" class="form-control @error('pelanggan_id') is-invalid @enderror">
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($pelanggans as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
            @endforeach
        </select>
        <div class="input-group-append">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalPelangganBaru">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    @error('pelanggan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
            <div class="form-group">
                <label>Produk</label>
                <select name="produk_id" class="form-control @error('produk_id') is-invalid @enderror" id="produkSelect">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $p)
                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}" {{ old('produk_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('produk_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" id="jumlahInput" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1">
                @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Total Harga (otomatis)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" id="totalHarga" class="form-control" readonly placeholder="Pilih produk & jumlah dulu">
                </div>
            </div>
            <div class="form-group">
                <label>Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}">
                @error('tanggal_transaksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

<!-- Modal Pelanggan Baru -->
<div class="modal fade" id="modalPelangganBaru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary">
                    <i class="fas fa-user-plus"></i> Tambah Pelanggan Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" id="new_nama" class="form-control" placeholder="Nama lengkap pelanggan">
                </div>
                <div class="form-group">
                    <label>No Telepon <span class="text-danger">*</span></label>
                    <input type="text" id="new_telepon" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="new_email" class="form-control" placeholder="opsional">
                </div>
                <div class="form-group">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea id="new_alamat" class="form-control" rows="2" placeholder="Alamat lengkap"></textarea>
                </div>
                <div id="modalError" class="alert alert-danger" style="display:none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="btnSimpanPelanggan" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan & Pilih
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Hitung total harga otomatis
    function hitungTotal() {
        const select  = document.getElementById('produkSelect');
        const jumlah  = document.getElementById('jumlahInput').value;
        const harga   = select.options[select.selectedIndex]?.dataset.harga || 0;
        const total   = harga * jumlah;
        document.getElementById('totalHarga').value = total.toLocaleString('id-ID');
    }
    document.getElementById('produkSelect').addEventListener('change', hitungTotal);
    document.getElementById('jumlahInput').addEventListener('input', hitungTotal);
   
    // Simpan pelanggan baru via AJAX
document.getElementById('btnSimpanPelanggan').addEventListener('click', function () {
    const nama     = document.getElementById('new_nama').value;
    const telepon  = document.getElementById('new_telepon').value;
    const email    = document.getElementById('new_email').value;
    const alamat   = document.getElementById('new_alamat').value;
    const errorDiv = document.getElementById('modalError');

    if (!nama || !telepon || !alamat) {
        errorDiv.style.display = 'block';
        errorDiv.innerText = 'Nama, No Telepon, dan Alamat wajib diisi!';
        return;
    }

    errorDiv.style.display = 'none';

    fetch('{{ route("pelanggan.ajax-store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ nama, no_telepon: telepon, email, alamat })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Tambah option baru ke select dan langsung pilih
            const select = document.getElementById('pelangganSelect');
            const option = new Option(data.nama, data.id, true, true);
            select.appendChild(option);
            select.value = data.id;

            // Reset form & tutup modal
            document.getElementById('new_nama').value    = '';
            document.getElementById('new_telepon').value = '';
            document.getElementById('new_email').value   = '';
            document.getElementById('new_alamat').value  = '';
            $('#modalPelangganBaru').modal('hide');
        }
    })
    .catch(() => {
        errorDiv.style.display = 'block';
        errorDiv.innerText = 'Terjadi kesalahan, coba lagi!';
    });
});
</script>
@endpush
@endsection