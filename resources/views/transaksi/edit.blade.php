@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Transaksi</h1>
    @section('content')

@if($transaksi->details->contains('is_frame_sendiri', true))
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    <strong>Transaksi ini mengandung item "Frame Bawa Sendiri".</strong>
    Form edit ini belum mendukung jenis item tersebut — mengedit transaksi ini berisiko menghilangkan data frame sendiri.
    Untuk perubahan kecil (status, catatan, metode bayar), silakan edit langsung lewat database atau hubungi developer.
</div>
@else

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Transaksi</h1>
    <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('transaksi.update', $transaksi) }}" method="POST" id="formTransaksi"></form>
    <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('transaksi.update', $transaksi) }}" method="POST" id="formTransaksi">
@csrf @method('PUT')
<div class="row">

    {{-- KIRI: Pilih Produk --}}
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shopping-cart"></i> Daftar Produk
                </h6>
            </div>
            <div class="card-body">
                <div id="produkContainer">
                    @foreach($transaksi->details as $detail)
                    <div class="produk-row row mb-3 align-items-end border-bottom pb-3">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Produk</label>
                            <select name="produk_id[]" class="form-control produk-select">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $p)
                                    <option value="{{ $p->id }}"
                                        data-harga="{{ $p->harga }}"
                                        data-stok="{{ $p->stok }}"
                                        {{ $detail->produk_id == $p->id ? 'selected' : '' }}>
                                        [{{ ucfirst($p->kategori) }}] {{ $p->nama_produk }}
                                        (Stok: {{ $p->stok }})
                                        - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" name="jumlah[]"
                                   class="form-control jumlah-input"
                                   value="{{ $detail->jumlah }}" min="1">
                        </div>
                        <div class="col-md-2">
                            <label class="font-weight-bold">Subtotal</label>
                            <input type="text" class="form-control subtotal-input bg-light"
                                   readonly
                                   value="Rp {{ number_format($detail->subtotal, 0, ',', '.') }}">
                        </div>
                        <div class="col-md-1 text-center">
                            <label class="d-block">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="button" id="btnTambahProduk" class="btn btn-success btn-sm mt-2">
                    <i class="fas fa-plus"></i> Tambah Produk Lain
                </button>

                <div class="mt-3 text-right">
                    <h5>Total Belanja:
                        <strong class="text-primary" id="grandTotal">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </strong>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {{-- KANAN: Info Transaksi --}}
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-receipt"></i> Info Transaksi
                </h6>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label class="font-weight-bold">Kode Transaksi</label>
                    <input type="text" class="form-control bg-light"
                           value="{{ $transaksi->kode_transaksi }}" readonly>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Pelanggan <span class="text-danger">*</span></label>
                    <select name="pelanggan_id" class="form-control">
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->id }}"
                                {{ $transaksi->pelanggan_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control"
                           value="{{ $transaksi->tanggal_transaksi }}">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Metode Pembayaran</label>
                    <select name="metode_bayar" id="metodeBayar" class="form-control">
                        <option value="tunai" {{ $transaksi->metode_bayar == 'tunai' ? 'selected' : '' }}>
                            💵 Tunai
                        </option>
                        <option value="transfer" {{ $transaksi->metode_bayar == 'transfer' ? 'selected' : '' }}>
                            🏦 Transfer
                        </option>
                        <option value="qris" {{ $transaksi->metode_bayar == 'qris' ? 'selected' : '' }}>
                            📱 QRIS
                        </option>
                    </select>
                </div>

                <div id="infoBayar"
                     style="{{ $transaksi->metode_bayar == 'tunai' ? '' : 'display:none' }}">
                    <div class="form-group">
                        <label class="font-weight-bold">Uang Bayar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="bayar" id="inputBayar"
                                   class="form-control"
                                   value="{{ $transaksi->bayar }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Kembalian</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" id="inputKembalian"
                                   class="form-control bg-light" readonly
                                   value="{{ number_format($transaksi->kembalian, 0, ',', '.') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Status</label>
                    <select name="status" class="form-control">
                        <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="dibatalkan" {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2">{{ $transaksi->catatan }}</textarea>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <i class="fas fa-save"></i> Update Transaksi
                </button>

            </div>
        </div>
    </div>

</div>
</form>

@endif





@push('scripts')
<script>
function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.produk-row').forEach(function(row) {
        const select = row.querySelector('.produk-select');
        const jumlah = parseFloat(row.querySelector('.jumlah-input').value) || 0;
        const harga  = parseFloat(select.options[select.selectedIndex]?.dataset.harga) || 0;
        const sub    = harga * jumlah;
        row.querySelector('.subtotal-input').value = sub > 0
            ? 'Rp ' + sub.toLocaleString('id-ID') : '';
        total += sub;
    });

    document.getElementById('grandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');

    const bayar     = parseFloat(document.getElementById('inputBayar').value) || 0;
    const kembalian = bayar - total;
    document.getElementById('inputKembalian').value = kembalian >= 0
        ? kembalian.toLocaleString('id-ID') : '0';
}

function bindRowEvents(row) {
    row.querySelector('.produk-select').addEventListener('change', hitungTotal);
    row.querySelector('.jumlah-input').addEventListener('input', hitungTotal);
    row.querySelector('.btn-hapus').addEventListener('click', function() {
        if (document.querySelectorAll('.produk-row').length > 1) {
            row.remove();
            hitungTotal();
        } else {
            alert('Minimal harus ada 1 produk!');
        }
    });
}

document.querySelectorAll('.produk-row').forEach(bindRowEvents);

document.getElementById('btnTambahProduk').addEventListener('click', function() {
    const container = document.getElementById('produkContainer');
    const firstRow  = container.querySelector('.produk-row');
    const newRow    = firstRow.cloneNode(true);
    newRow.querySelector('.produk-select').value  = '';
    newRow.querySelector('.jumlah-input').value   = '1';
    newRow.querySelector('.subtotal-input').value = '';
    container.appendChild(newRow);
    bindRowEvents(newRow);
});

document.getElementById('metodeBayar').addEventListener('change', function() {
    document.getElementById('infoBayar').style.display =
        this.value === 'tunai' ? 'block' : 'none';
});

document.getElementById('inputBayar').addEventListener('input', hitungTotal);

// Hitung total saat halaman load
hitungTotal();
</script>
@endpush
@endsection