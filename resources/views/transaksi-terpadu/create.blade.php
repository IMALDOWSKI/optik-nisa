@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Baru</h1>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
    </a>
</div>

{{-- Progress Steps --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center" id="progressSteps">
            <div class="step-item active" data-step="1">
                <div class="step-circle">1</div>
                <div class="step-label">Pelanggan</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="2">
                <div class="step-circle">2</div>
                <div class="step-label">Resep Mata</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="3">
                <div class="step-circle">3</div>
                <div class="step-label">Produk</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="4">
                <div class="step-circle">4</div>
                <div class="step-label">Checkout</div>
            </div>
        </div>
    </div>
</div>

<form id="formTransaksiTerpadu" method="POST" action="{{ route('transaksi-terpadu.store') }}">
    @csrf

    {{-- Hidden field untuk pelanggan terpilih --}}
    <input type="hidden" name="pelanggan_id" id="pelanggan_id" required>
    <input type="hidden" name="resep_mode" id="resep_mode" value="tidak_ada">
    <input type="hidden" name="resep_id" id="resep_id_input">

    {{-- ===================== TAHAP 1: PELANGGAN ===================== --}}
    <div class="tahap-form" id="tahap-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user mr-2"></i>Cari atau Tambah Pelanggan
                </h6>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Ketik nama atau no. telepon pelanggan</label>
                    <input type="text" id="cariPelanggan" class="form-control form-control-lg"
                           placeholder="Mulai ketik untuk mencari..." autocomplete="off">
                    <div id="hasilCariPelanggan" class="list-group mt-2" style="display:none;"></div>
                </div>

                {{-- Kartu pelanggan terpilih --}}
                <div id="pelangganTerpilih" style="display:none;" class="alert alert-success mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong id="namaPelangganTerpilih"></strong>
                            <div class="small text-muted" id="infoPelangganTerpilih"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnGantiPelanggan">
                            Ganti
                        </button>
                    </div>
                </div>

                <hr>

                <div class="text-center">
                    <span class="text-muted">Pelanggan baru?</span>
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#formPelangganBaru">
                        Klik di sini untuk tambah data baru
                    </button>
                </div>

                <div class="collapse" id="formPelangganBaru">
                    <div class="card card-body bg-light mt-2">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Lengkap</label>
                                <input type="text" id="newNama" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>No. Telepon</label>
                                <input type="text" id="newTelepon" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email (opsional)</label>
                                <input type="email" id="newEmail" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Alamat</label>
                                <input type="text" id="newAlamat" class="form-control">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="btnSimpanPelangganBaru">
                            <i class="fas fa-save mr-1"></i>Simpan & Pilih Pelanggan Ini
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-primary" id="btnLanjutTahap2" disabled>
                    Lanjut ke Resep Mata <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== TAHAP 2: RESEP MATA ===================== --}}
<div class="tahap-form" id="tahap-2">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-eye mr-2"></i>Resep Mata
            </h6>
        </div>
        <div class="card-body">

            {{-- Riwayat resep (muncul kalau pelanggan lama punya riwayat) --}}
            <div id="riwayatResepWrapper" style="display:none;">
                <label class="font-weight-bold">Riwayat Resep Pelanggan Ini</label>
                <div id="daftarRiwayatResep"></div>
                <hr>
            </div>

            <div id="tanpaRiwayatResep" class="alert alert-info" style="display:none;">
                <i class="fas fa-info-circle mr-2"></i>Pelanggan ini belum punya riwayat resep mata.
            </div>

            {{-- Pilihan aksi --}}
            <div class="form-group">
                <button type="button" class="btn btn-outline-primary" id="btnBuatResepBaru">
                    <i class="fas fa-plus mr-1"></i>Buat Resep Baru
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnTanpaResep">
                    <i class="fas fa-forward mr-1"></i>Lewati (Tidak Perlu Resep)
                </button>
            </div>

            {{-- Indikator resep yang sedang aktif dipakai --}}
            <div id="resepTerpilihInfo" class="alert alert-success" style="display:none;"></div>

            {{-- Form resep baru --}}
            <div id="formResepBaru" style="display:none;" class="card card-body bg-light">
                <h6 class="font-weight-bold mb-3">Input Resep Baru</h6>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Mata Kanan (OD)</h6>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>SPH</label>
                                <input type="number" step="0.25" name="od_sph" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>CYL</label>
                                <input type="number" step="0.25" name="od_cyl" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Axis</label>
                                <input type="number" name="od_axis" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Add</label>
                                <input type="number" step="0.25" name="od_add" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Mata Kiri (OS)</h6>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>SPH</label>
                                <input type="number" step="0.25" name="os_sph" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>CYL</label>
                                <input type="number" step="0.25" name="os_cyl" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Axis</label>
                                <input type="number" name="os_axis" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Add</label>
                                <input type="number" step="0.25" name="os_add" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>PD Kanan</label>
                        <input type="number" step="0.25" name="pd_kanan" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>PD Kiri</label>
                        <input type="number" step="0.25" name="pd_kiri" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Diperiksa Oleh (opsional)</label>
                        <input type="text" name="dokter" class="form-control" placeholder="Nama optometris">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Catatan</label>
                        <input type="text" name="catatan_resep" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="btnSimpanResepForm">
                    <i class="fas fa-check mr-1"></i>Gunakan Resep Ini
                </button>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="btnKembaliTahap1">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </button>
            <button type="button" class="btn btn-primary" id="btnLanjutTahap3" disabled>
                Lanjut ke Produk <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
</div>


{{-- ===================== TAHAP 3: PRODUK ===================== --}}
<div class="tahap-form" id="tahap-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-glasses mr-2"></i>Pilih Produk
            </h6>
        </div>
        <div class="card-body">

            {{-- Toggle Frame Sendiri --}}
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="cekFrameSendiri">
                <label class="custom-control-label" for="cekFrameSendiri">
                    <strong>Pelanggan Bawa Frame Sendiri</strong>
                </label>
            </div>

            <div id="ketFrameSendiriWrapper" style="display:none;" class="form-group">
                <label>Keterangan Frame (opsional)</label>
                <input type="text" id="ketFrameSendiri" class="form-control" placeholder="Contoh: Frame Rayban hitam milik pelanggan">
            </div>

            <hr>

            {{-- Tambah produk dari katalog --}}
            <div class="form-row align-items-end">
                <div class="form-group col-md-6">
                    <label>Pilih Produk</label>
                    <select id="pilihProduk" class="form-control">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $p)
                            <option value="{{ $p->id }}"
                                    data-nama="{{ $p->nama_produk }}"
                                    data-harga="{{ $p->harga }}"
                                    data-stok="{{ $p->stok }}">
                                {{ $p->nama_produk }} — Rp {{ number_format($p->harga, 0, ',', '.') }} (Stok: {{ $p->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Jumlah</label>
                    <input type="number" id="jumlahProduk" class="form-control" value="1" min="1">
                </div>
                <div class="form-group col-md-3">
                    <button type="button" class="btn btn-primary btn-block" id="btnTambahItem">
                        <i class="fas fa-plus mr-1"></i>Tambah
                    </button>
                </div>
            </div>

            {{-- Daftar item yang sudah ditambahkan --}}
            <table class="table table-bordered mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Item</th>
                        <th width="100">Jumlah</th>
                        <th width="150">Harga Satuan</th>
                        <th width="150">Subtotal</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody id="daftarItemKeranjang">
                    <tr id="keranjangKosong">
                        <td colspan="5" class="text-center text-muted py-3">Belum ada item ditambahkan</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th id="totalKeranjang">Rp 0</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="card-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="btnKembaliTahap2">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </button>
            <button type="button" class="btn btn-primary" id="btnLanjutTahap4" disabled>
                Lanjut ke Checkout <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
</div>

{{-- ===================== TAHAP 4: CHECKOUT ===================== --}}
<div class="tahap-form" id="tahap-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-cash-register mr-2"></i>Checkout
            </h6>
        </div>
        <div class="card-body">

            {{-- Ringkasan --}}
            <div class="alert alert-light border">
                <h6 class="font-weight-bold mb-2">Ringkasan Item</h6>
                <table class="table table-sm mb-0" id="ringkasanItemTable"></table>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Subtotal</strong>
                    <strong id="ringkasanSubtotal">Rp 0</strong>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Metode Pembayaran</label>
                    <select name="metode_bayar" class="form-control" required>
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Diskon</label>
                    <div class="input-group">
                        <input type="number" name="diskon" id="inputDiskon" class="form-control" value="0" min="0">
                        <div class="input-group-append">
                            <select name="tipe_diskon" id="tipeDiskon" class="form-control">
                                <option value="nominal">Rp</option>
                                <option value="persen">%</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Grand Total</label>
                    <input type="text" id="grandTotalTampil" class="form-control font-weight-bold" readonly>
                </div>
            </div>

            {{-- Tipe Bayar --}}
            <div class="form-group">
                <label>Tipe Pembayaran</label>
                <div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="bayarLunas" name="tipe_bayar" value="lunas" class="custom-control-input" checked>
                        <label class="custom-control-label" for="bayarLunas">Lunas</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="bayarDp" name="tipe_bayar" value="dp" class="custom-control-input">
                        <label class="custom-control-label" for="bayarDp">DP / Cicil</label>
                    </div>
                </div>
            </div>

            {{-- Field untuk Lunas --}}
            <div id="fieldLunas" class="form-row">
                <div class="form-group col-md-6">
                    <label>Jumlah Dibayar</label>
                    <input type="number" name="bayar" id="inputBayar" class="form-control" min="0">
                </div>
                <div class="form-group col-md-6">
                    <label>Kembalian</label>
                    <input type="text" id="kembalianTampil" class="form-control" readonly>
                </div>
            </div>

            {{-- Field untuk DP --}}
            <div id="fieldDp" class="form-row" style="display:none;">
                <div class="form-group col-md-6">
                    <label>Jumlah DP</label>
                    <input type="number" name="dp" id="inputDp" class="form-control" min="0">
                </div>
                <div class="form-group col-md-6">
                    <label>Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="2"></textarea>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="btnKembaliTahap3">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </button>
            <button type="submit" class="btn btn-success btn-lg" id="btnSimpanTransaksi">
                <i class="fas fa-check-circle mr-1"></i>Simpan Transaksi
            </button>
        </div>
    </div>
</div>

{{-- Container tersembunyi untuk hidden input item, di-generate via JS sebelum submit --}}
<div id="hiddenItemInputs"></div>
</form>

@endsection

@push('scripts')
<style>
    #progressSteps {
        position: relative;
    }
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 2;
    }
    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e8ecf0;
        color: #888;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.3s;
    }
    .step-item.active .step-circle {
        background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
        color: white;
    }
    .step-item.done .step-circle {
        background: #00b4d8;
        color: white;
    }
    .step-label {
        font-size: 0.75rem;
        margin-top: 6px;
        color: #888;
        font-weight: 600;
    }
    .step-item.active .step-label {
        color: #1a3a5c;
    }
    .step-line {
        flex: 1;
        height: 2px;
        background: #e8ecf0;
        margin: 0 10px;
        margin-bottom: 20px;
    }
    .tahap-form {
        display: none;
    }
    .tahap-form.show {
        display: block;
    }
    #hasilCariPelanggan .list-group-item {
        cursor: pointer;
    }
    #hasilCariPelanggan .list-group-item:hover {
        background: #f0f7ff;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan tahap 1 di awal
    document.getElementById('tahap-1').classList.add('show');

    let pelangganTerpilihData = null;

    function updateStepIndicator(activeStep) {
    document.querySelectorAll('.step-item').forEach(item => {
        const stepNum = parseInt(item.dataset.step);
        item.classList.remove('active', 'done');
        if (stepNum < activeStep) {
            item.classList.add('done');
        } else if (stepNum === activeStep) {
            item.classList.add('active');
        }
    });
}

    // ===== CARI PELANGGAN (AJAX) =====
    const inputCari = document.getElementById('cariPelanggan');
    const hasilCari = document.getElementById('hasilCariPelanggan');
    let timeoutCari;

    inputCari.addEventListener('input', function() {
        clearTimeout(timeoutCari);
        const keyword = this.value.trim();

        if (keyword.length < 2) {
            hasilCari.style.display = 'none';
            return;
        }

        timeoutCari = setTimeout(() => {
            fetch(`{{ route('pelanggan.ajax-search') }}?q=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    hasilCari.innerHTML = '';

                    if (data.length === 0) {
                        hasilCari.innerHTML = '<div class="list-group-item text-muted">Tidak ditemukan. Coba tambah sebagai pelanggan baru di bawah.</div>';
                    } else {
                        data.forEach(p => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = `<strong>${p.nama}</strong><div class="small text-muted">${p.no_telepon} — ${p.alamat ?? ''}</div>`;
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                pilihPelanggan(p);
                            });
                            hasilCari.appendChild(item);
                        });
                    }

                    hasilCari.style.display = 'block';
                });
        }, 350);
    });

    // ===== PILIH PELANGGAN =====
    function pilihPelanggan(p) {
        pelangganTerpilihData = p;

        document.getElementById('pelanggan_id').value = p.id;
        document.getElementById('namaPelangganTerpilih').textContent = p.nama;
        document.getElementById('infoPelangganTerpilih').textContent = p.no_telepon + (p.alamat ? ' — ' + p.alamat : '');
        document.getElementById('pelangganTerpilih').style.display = 'block';

        inputCari.value = '';
        inputCari.style.display = 'none';
        hasilCari.style.display = 'none';

        document.getElementById('btnLanjutTahap2').disabled = false;

        // Muat riwayat resep untuk dipakai di Tahap 2 nanti
        muatRiwayatResep(p.id);
    }

    // ===== GANTI PELANGGAN =====
    document.getElementById('btnGantiPelanggan').addEventListener('click', function() {
        pelangganTerpilihData = null;
        document.getElementById('pelanggan_id').value = '';
        document.getElementById('pelangganTerpilih').style.display = 'none';
        inputCari.style.display = 'block';
        inputCari.value = '';
        inputCari.focus();
        document.getElementById('btnLanjutTahap2').disabled = true;
    });

    // ===== SIMPAN PELANGGAN BARU (AJAX) =====
    document.getElementById('btnSimpanPelangganBaru').addEventListener('click', function() {
        const nama     = document.getElementById('newNama').value.trim();
        const telepon  = document.getElementById('newTelepon').value.trim();
        const email    = document.getElementById('newEmail').value.trim();
        const alamat   = document.getElementById('newAlamat').value.trim();

        if (!nama || !telepon || !alamat) {
            alert('Nama, No. Telepon, dan Alamat wajib diisi.');
            return;
        }

        const formData = new FormData();
        formData.append('nama', nama);
        formData.append('no_telepon', telepon);
        formData.append('email', email);
        formData.append('alamat', alamat);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("pelanggan.ajax-store") }}', {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                pilihPelanggan({
                    id: data.id,
                    nama: data.nama,
                    no_telepon: telepon,
                    alamat: alamat,
                });
                document.getElementById('formPelangganBaru').classList.remove('show');
            }
        });
    });

    // ===== MUAT RIWAYAT RESEP (dipanggil, dipakai nanti di Tahap 2) =====
    let riwayatResepData = [];

function muatRiwayatResep(pelangganId) {
    fetch(`/pelanggan/${pelangganId}/ajax-riwayat-resep`)
        .then(res => res.json())
        .then(data => {
            riwayatResepData = data;
            tampilkanRiwayatResep(data);
        });
}

function tampilkanRiwayatResep(data) {
    const wrapper = document.getElementById('riwayatResepWrapper');
    const tanpaRiwayat = document.getElementById('tanpaRiwayatResep');
    const daftar = document.getElementById('daftarRiwayatResep');

    daftar.innerHTML = '';

    if (data.length === 0) {
        wrapper.style.display = 'none';
        tanpaRiwayat.style.display = 'block';
        return;
    }

    tanpaRiwayat.style.display = 'none';
    wrapper.style.display = 'block';

    data.forEach(r => {
        const tanggal = new Date(r.tanggal_periksa).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const card = document.createElement('div');
        card.className = 'card card-body mb-2';
        card.style.cursor = 'pointer';
        card.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong><i class="far fa-clock mr-1"></i>${tanggal}</strong>
                    <div class="small text-muted">
                        OD: Sph ${fmtNilai(r.od_sph)} Cyl ${fmtNilai(r.od_cyl)} Axis ${r.od_axis ?? '-'}°
                        &nbsp;|&nbsp;
                        OS: Sph ${fmtNilai(r.os_sph)} Cyl ${fmtNilai(r.os_cyl)} Axis ${r.os_axis ?? '-'}°
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary btn-pilih-resep">Pilih</button>
            </div>
        `;
        card.querySelector('.btn-pilih-resep').addEventListener('click', () => pilihResepLama(r, tanggal));
        daftar.appendChild(card);
    });
}

function fmtNilai(n) {
    if (n === null || n === undefined) return '-';
    return n > 0 ? '+' + parseFloat(n).toFixed(2) : parseFloat(n).toFixed(2);
}

function pilihResepLama(resep, tanggalText) {
    document.getElementById('resep_mode').value = 'lama';
    document.getElementById('resep_id_input').value = resep.id;

    document.getElementById('formResepBaru').style.display = 'none';
    const info = document.getElementById('resepTerpilihInfo');
    info.style.display = 'block';
    info.innerHTML = `<i class="fas fa-check-circle mr-2"></i>Memakai resep tanggal <strong>${tanggalText}</strong>`;

    document.getElementById('btnLanjutTahap3').disabled = false;
}

document.getElementById('btnBuatResepBaru').addEventListener('click', function() {
    document.getElementById('formResepBaru').style.display = 'block';
    document.getElementById('resepTerpilihInfo').style.display = 'none';
    document.getElementById('btnLanjutTahap3').disabled = true;
});

document.getElementById('btnTanpaResep').addEventListener('click', function() {
    document.getElementById('resep_mode').value = 'tidak_ada';
    document.getElementById('resep_id_input').value = '';
    document.getElementById('formResepBaru').style.display = 'none';

    const info = document.getElementById('resepTerpilihInfo');
    info.style.display = 'block';
    info.innerHTML = '<i class="fas fa-info-circle mr-2"></i>Transaksi ini tanpa resep mata (misalnya hanya beli aksesoris).';

    document.getElementById('btnLanjutTahap3').disabled = false;
});

document.getElementById('btnSimpanResepForm').addEventListener('click', function() {
    document.getElementById('resep_mode').value = 'baru';
    document.getElementById('resep_id_input').value = '';

    const info = document.getElementById('resepTerpilihInfo');
    info.style.display = 'block';
    info.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Resep baru akan disimpan saat transaksi diselesaikan.';

    document.getElementById('btnLanjutTahap3').disabled = false;
});

document.getElementById('btnKembaliTahap1').addEventListener('click', function() {
    document.getElementById('tahap-2').classList.remove('show');
    document.getElementById('tahap-1').classList.add('show');
    updateStepIndicator(1);
});

document.getElementById('btnLanjutTahap3').addEventListener('click', function() {
    document.getElementById('tahap-2').classList.remove('show');
    document.getElementById('tahap-3').classList.add('show');
    updateStepIndicator(3);
});

    // ===== NAVIGASI TAHAP =====
document.getElementById('btnLanjutTahap2').addEventListener('click', function() {
    document.getElementById('tahap-1').classList.remove('show');
    document.getElementById('tahap-2').classList.add('show');
    updateStepIndicator(2);
});

// ===== TAHAP 3: PRODUK =====
let keranjang = [];
let keranjangCounter = 0;

document.getElementById('cekFrameSendiri').addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('ketFrameSendiriWrapper').style.display = 'block';
        tambahFrameSendiriKeKeranjang();
    } else {
        document.getElementById('ketFrameSendiriWrapper').style.display = 'none';
        // Hapus item frame sendiri dari keranjang kalau dibatalkan
        keranjang = keranjang.filter(item => item.jenis !== 'frame_sendiri');
        renderKeranjang();
    }
});

function tambahFrameSendiriKeKeranjang() {
    const sudahAda = keranjang.some(item => item.jenis === 'frame_sendiri');
    if (sudahAda) return;

    keranjang.push({
        uid: keranjangCounter++,
        jenis: 'frame_sendiri',
        nama: 'Frame Milik Pelanggan',
        jumlah: 1,
        harga: 0,
        subtotal: 0,
        keterangan: document.getElementById('ketFrameSendiri').value || '',
    });
    renderKeranjang();
}

document.getElementById('ketFrameSendiri').addEventListener('input', function() {
    const item = keranjang.find(i => i.jenis === 'frame_sendiri');
    if (item) {
        item.keterangan = this.value;
    }
});

document.getElementById('btnTambahItem').addEventListener('click', function() {
    const select = document.getElementById('pilihProduk');
    const opt = select.options[select.selectedIndex];

    if (!select.value) {
        alert('Pilih produk terlebih dahulu.');
        return;
    }

    const jumlah = parseInt(document.getElementById('jumlahProduk').value) || 1;
    const stok = parseInt(opt.dataset.stok);

    if (jumlah > stok) {
        alert(`Stok tidak cukup. Sisa stok: ${stok}`);
        return;
    }

    const harga = parseFloat(opt.dataset.harga);

    keranjang.push({
        uid: keranjangCounter++,
        jenis: 'produk',
        produkId: select.value,
        nama: opt.dataset.nama,
        jumlah: jumlah,
        harga: harga,
        subtotal: harga * jumlah,
    });

    renderKeranjang();

    select.value = '';
    document.getElementById('jumlahProduk').value = 1;
});

function hapusItemKeranjang(uid) {
    const item = keranjang.find(i => i.uid === uid);
    if (item && item.jenis === 'frame_sendiri') {
        document.getElementById('cekFrameSendiri').checked = false;
        document.getElementById('ketFrameSendiriWrapper').style.display = 'none';
    }
    keranjang = keranjang.filter(i => i.uid !== uid);
    renderKeranjang();
}

function renderKeranjang() {
    const tbody = document.getElementById('daftarItemKeranjang');
    tbody.innerHTML = '';

    if (keranjang.length === 0) {
        tbody.innerHTML = '<tr id="keranjangKosong"><td colspan="5" class="text-center text-muted py-3">Belum ada item ditambahkan</td></tr>';
        document.getElementById('totalKeranjang').textContent = 'Rp 0';
        document.getElementById('btnLanjutTahap4').disabled = true;
        return;
    }

    let total = 0;

    keranjang.forEach(item => {
        total += item.subtotal;
        const tr = document.createElement('tr');
        const namaTampil = item.jenis === 'frame_sendiri'
            ? `<span class="badge badge-info mr-1">Bawa Sendiri</span>${item.nama}${item.keterangan ? ' — ' + item.keterangan : ''}`
            : item.nama;

        tr.innerHTML = `
            <td>${namaTampil}</td>
            <td>${item.jumlah}</td>
            <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
            <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
            <td><button type="button" class="btn btn-sm btn-danger btn-hapus-item"><i class="fas fa-trash"></i></button></td>
        `;
        tr.querySelector('.btn-hapus-item').addEventListener('click', () => hapusItemKeranjang(item.uid));
        tbody.appendChild(tr);
    });

    document.getElementById('totalKeranjang').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('btnLanjutTahap4').disabled = false;
}

document.getElementById('btnKembaliTahap2').addEventListener('click', function() {
    document.getElementById('tahap-3').classList.remove('show');
    document.getElementById('tahap-2').classList.add('show');
    updateStepIndicator(2);
});

document.getElementById('btnLanjutTahap4').addEventListener('click', function() {
    document.getElementById('tahap-3').classList.remove('show');
    document.getElementById('tahap-4').classList.add('show');
    renderRingkasanCheckout();
    updateStepIndicator(4);
});

// ===== TAHAP 4: CHECKOUT =====

document.getElementById('btnLanjutTahap4').addEventListener('click', function() {
    document.getElementById('tahap-3').classList.remove('show');
    document.getElementById('tahap-4').classList.add('show');
    renderRingkasanCheckout();
});

function renderRingkasanCheckout() {
    const tbody = document.getElementById('ringkasanItemTable');
    tbody.innerHTML = '';
    let subtotal = 0;

    keranjang.forEach(item => {
        subtotal += item.subtotal;
        const row = document.createElement('tr');
        const nama = item.jenis === 'frame_sendiri' ? item.nama + ' (Bawa Sendiri)' : item.nama;
        row.innerHTML = `<td>${nama} x${item.jumlah}</td><td class="text-right">Rp ${item.subtotal.toLocaleString('id-ID')}</td>`;
        tbody.appendChild(row);
    });

    document.getElementById('ringkasanSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    hitungGrandTotal();
}

function hitungGrandTotal() {
    const subtotal = keranjang.reduce((sum, item) => sum + item.subtotal, 0);
    const diskonInput = parseFloat(document.getElementById('inputDiskon').value) || 0;
    const tipeDiskon = document.getElementById('tipeDiskon').value;

    let diskon = tipeDiskon === 'persen' ? subtotal * (diskonInput / 100) : diskonInput;
    const grandTotal = subtotal - diskon;

    document.getElementById('grandTotalTampil').value = 'Rp ' + grandTotal.toLocaleString('id-ID');

    hitungKembalian(grandTotal);
    return grandTotal;
}

document.getElementById('inputDiskon').addEventListener('input', hitungGrandTotal);
document.getElementById('tipeDiskon').addEventListener('change', hitungGrandTotal);

function hitungKembalian(grandTotal) {
    const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
    const kembalian = bayar - grandTotal;
    document.getElementById('kembalianTampil').value = 'Rp ' + (kembalian > 0 ? kembalian.toLocaleString('id-ID') : '0');
}

document.getElementById('inputBayar').addEventListener('input', function() {
    hitungKembalian(hitungGrandTotal());
});

// Toggle Lunas vs DP
document.querySelectorAll('input[name="tipe_bayar"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'dp') {
            document.getElementById('fieldLunas').style.display = 'none';
            document.getElementById('fieldDp').style.display = 'flex';
            document.getElementById('inputBayar').removeAttribute('required');
        } else {
            document.getElementById('fieldLunas').style.display = 'flex';
            document.getElementById('fieldDp').style.display = 'none';
        }
    });
});

document.getElementById('btnKembaliTahap3').addEventListener('click', function() {
    document.getElementById('tahap-4').classList.remove('show');
    document.getElementById('tahap-3').classList.add('show');
    updateStepIndicator(3);
});

// ===== SUBMIT FORM: generate hidden input dari keranjang sebelum kirim =====
document.getElementById('formTransaksiTerpadu').addEventListener('submit', function(e) {
    if (keranjang.length === 0) {
        e.preventDefault();
        alert('Belum ada item di keranjang.');
        return;
    }

    const container = document.getElementById('hiddenItemInputs');
    container.innerHTML = '';

    keranjang.forEach((item, i) => {
        const jenisInput = document.createElement('input');
        jenisInput.type = 'hidden';
        jenisInput.name = `item_jenis[${i}]`;
        jenisInput.value = item.jenis;
        container.appendChild(jenisInput);

        const jumlahInput = document.createElement('input');
        jumlahInput.type = 'hidden';
        jumlahInput.name = `item_jumlah[${i}]`;
        jumlahInput.value = item.jumlah;
        container.appendChild(jumlahInput);

        if (item.jenis === 'produk') {
            const produkInput = document.createElement('input');
            produkInput.type = 'hidden';
            produkInput.name = `item_produk_id[${i}]`;
            produkInput.value = item.produkId;
            container.appendChild(produkInput);
        } else {
            const ketInput = document.createElement('input');
            ketInput.type = 'hidden';
            ketInput.name = `item_keterangan_frame[${i}]`;
            ketInput.value = item.keterangan || '';
            container.appendChild(ketInput);
        }
    });
});
});
</script>
@endpush