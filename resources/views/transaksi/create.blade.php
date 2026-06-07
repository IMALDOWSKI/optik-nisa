@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Baru</h1>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
@csrf
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
                    {{-- Baris produk pertama --}}
                    <div class="produk-row row mb-3 align-items-end border-bottom pb-3">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Produk <span class="text-danger">*</span></label>
                            <select name="produk_id[]" class="form-control produk-select">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $p)
                                    <option value="{{ $p->id }}"
                                        data-harga="{{ $p->harga }}"
                                        data-stok="{{ $p->stok }}">
                                        [{{ ucfirst($p->kategori) }}] {{ $p->nama_produk }}
                                        (Stok: {{ $p->stok }})
                                        - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number"
                                   name="jumlah[]"
                                   class="form-control jumlah-input"
                                   value="1" min="1">
                        </div>
                        <div class="col-md-2">
                            <label class="font-weight-bold">Subtotal</label>
                            <input type="text"
                                   class="form-control subtotal-input bg-light"
                                   readonly
                                   placeholder="Rp 0">
                        </div>
                        <div class="col-md-1 text-center">
                            <label class="d-block">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" id="btnTambahProduk" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Produk Lain
                </button>

                <div class="mt-3 text-right">
                    <h5>Total Belanja:
                        <strong class="text-primary" id="grandTotal">Rp 0</strong>
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

                {{-- Pelanggan --}}
                <div class="form-group">
                    <label class="font-weight-bold">Pelanggan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="pelanggan_id" id="pelangganSelect"
                                class="form-control @error('pelanggan_id') is-invalid @enderror">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#modalPelangganBaru"
                                    title="Tambah Pelanggan Baru">
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                    @error('pelanggan_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Transaksi</label>
                    <input type="date"
                           name="tanggal_transaksi"
                           class="form-control"
                           value="{{ date('Y-m-d') }}">
                </div>

                {{-- Metode Bayar --}}
                <div class="form-group">
                    <label class="font-weight-bold">Metode Pembayaran</label>
                    <select name="metode_bayar" id="metodeBayar" class="form-control">
                        <option value="tunai">💵 Tunai</option>
                        <option value="transfer">🏦 Transfer</option>
                        <option value="qris">📱 QRIS</option>
                    </select>
                </div>

                {{-- Diskon --}}
<div class="form-group">
    <label class="font-weight-bold">Diskon</label>
    <div class="input-group">
        <select name="tipe_diskon" id="tipeDiskon" class="form-control" style="max-width:110px">
            <option value="nominal">Nominal</option>
            <option value="persen">Persen (%)</option>
        </select>
        <input type="number" name="diskon" id="inputDiskon"
               class="form-control" placeholder="0" min="0">
        <div class="input-group-append">
            <span class="input-group-text" id="satuanDiskon">Rp</span>
        </div>
    </div>
</div>

{{-- Grand Total --}}
<div class="form-group">
    <label class="font-weight-bold">Grand Total</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Rp</span>
        </div>
        <input type="text" id="grandTotalFinal"
               class="form-control bg-light font-weight-bold"
               readonly placeholder="0">
    </div>
</div>
                {{-- Info Bayar (hanya muncul kalau Tunai) --}}
                <div id="infoBayar">
                    <div class="form-group">
                        <label class="font-weight-bold">Uang Bayar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number"
                                   name="bayar"
                                   id="inputBayar"
                                   class="form-control"
                                   placeholder="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Kembalian</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text"
                                   id="inputKembalian"
                                   class="form-control bg-light"
                                   readonly
                                   placeholder="0">
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="form-group">
                    <label class="font-weight-bold">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2"
                              placeholder="Opsional..."></textarea>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <i class="fas fa-save"></i> Simpan Transaksi
                </button>

            </div>
        </div>
    </div>

</div>
</form>

{{-- Modal Tambah Pelanggan Baru --}}
<div class="modal fade" id="modalPelangganBaru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i> Tambah Pelanggan Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="new_nama" class="form-control"
                           placeholder="Nama lengkap pelanggan">
                </div>
                <div class="form-group">
                    <label>No Telepon <span class="text-danger">*</span></label>
                    <input type="text" id="new_telepon" class="form-control"
                           placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Email <small class="text-muted">(opsional)</small></label>
                    <input type="email" id="new_email" class="form-control"
                           placeholder="email@contoh.com">
                </div>
                <div class="form-group">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea id="new_alamat" class="form-control" rows="2"
                              placeholder="Alamat lengkap"></textarea>
                </div>
                <div id="modalError" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Batal
                </button>
                <button type="button" id="btnSimpanPelanggan" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan & Pilih
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ================================================
// HITUNG TOTAL
// ================================================
function hitungTotal() {
    let total = 0;

    document.querySelectorAll('.produk-row').forEach(function(row) {
        const select  = row.querySelector('.produk-select');
        const jumlah  = parseFloat(row.querySelector('.jumlah-input').value) || 0;
        const harga   = parseFloat(select.options[select.selectedIndex]?.dataset.harga) || 0;
        const sub     = harga * jumlah;
        row.querySelector('.subtotal-input').value = sub > 0
            ? 'Rp ' + sub.toLocaleString('id-ID') : '';
        total += sub;
    });

    // Hitung diskon
    const tipeDiskon  = document.getElementById('tipeDiskon').value;
    const nilaiDiskon = parseFloat(document.getElementById('inputDiskon').value) || 0;
    let diskon = 0;

    if (tipeDiskon === 'persen') {
        diskon = total * (nilaiDiskon / 100);
    } else {
        diskon = nilaiDiskon;
    }

    const grandTotal = total - diskon;

    document.getElementById('grandTotal').innerText =
        'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('grandTotalFinal').value =
        grandTotal.toLocaleString('id-ID');

    // Hitung kembalian
    const bayar     = parseFloat(document.getElementById('inputBayar').value) || 0;
    const kembalian = bayar - grandTotal;
    document.getElementById('inputKembalian').value = kembalian >= 0
        ? kembalian.toLocaleString('id-ID') : '0';
}
    // Update satuan diskon
document.getElementById('tipeDiskon').addEventListener('change', function() {
    document.getElementById('satuanDiskon').innerText =
        this.value === 'persen' ? '%' : 'Rp';
    hitungTotal();
});
// ================================================
// BIND EVENTS KE SATU BARIS PRODUK
// ================================================
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

// Bind ke baris pertama
document.querySelectorAll('.produk-row').forEach(bindRowEvents);

// ================================================
// TAMBAH BARIS PRODUK BARU
// ================================================
document.getElementById('btnTambahProduk').addEventListener('click', function() {
    const container  = document.getElementById('produkContainer');
    const firstRow   = container.querySelector('.produk-row');
    const newRow     = firstRow.cloneNode(true);

    // Reset nilai baris baru
    newRow.querySelector('.produk-select').value  = '';
    newRow.querySelector('.jumlah-input').value   = '1';
    newRow.querySelector('.subtotal-input').value = '';

    container.appendChild(newRow);
    bindRowEvents(newRow);
});

// ================================================
// TOGGLE INFO BAYAR (TUNAI/TRANSFER/QRIS)
// ================================================
document.getElementById('metodeBayar').addEventListener('change', function() {
    document.getElementById('infoBayar').style.display =
        this.value === 'tunai' ? 'block' : 'none';
});

document.getElementById('inputBayar').addEventListener('input', hitungTotal);

// ================================================
// AJAX SIMPAN PELANGGAN BARU
// ================================================
document.getElementById('btnSimpanPelanggan').addEventListener('click', function() {
    const nama    = document.getElementById('new_nama').value.trim();
    const telepon = document.getElementById('new_telepon').value.trim();
    const email   = document.getElementById('new_email').value.trim();
    const alamat  = document.getElementById('new_alamat').value.trim();
    const errDiv  = document.getElementById('modalError');

    if (!nama || !telepon || !alamat) {
        errDiv.classList.remove('d-none');
        errDiv.innerText = 'Nama, No Telepon, dan Alamat wajib diisi!';
        return;
    }

    errDiv.classList.add('d-none');

    fetch('{{ route("pelanggan.ajax-store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            nama       : nama,
            no_telepon : telepon,
            email      : email,
            alamat     : alamat
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('pelangganSelect');
            const option = new Option(data.nama, data.id, true, true);
            select.appendChild(option);
            select.value = data.id;

            // Reset modal
            document.getElementById('new_nama').value    = '';
            document.getElementById('new_telepon').value = '';
            document.getElementById('new_email').value   = '';
            document.getElementById('new_alamat').value  = '';

            $('#modalPelangganBaru').modal('hide');
        }
    })
    .catch(function() {
        errDiv.classList.remove('d-none');
        errDiv.innerText = 'Terjadi kesalahan, coba lagi!';
    });
});
</script>
@endpush
@endsection