@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Transaksi Baru</h1>
        <small class="text-muted">Ikuti langkah-langkah berikut untuk membuat transaksi</small>
    </div>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
    </a>
</div>

{{-- Progress Steps --}}
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center" id="progressSteps">
            <div class="step-item active" data-step="1">
                <div class="step-circle"><i class="fas fa-user"></i></div>
                <div class="step-label">Pelanggan</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="2">
                <div class="step-circle"><i class="fas fa-eye"></i></div>
                <div class="step-label">Resep Mata</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="3">
                <div class="step-circle"><i class="fas fa-glasses"></i></div>
                <div class="step-label">Produk</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="4">
                <div class="step-circle"><i class="fas fa-cash-register"></i></div>
                <div class="step-label">Checkout</div>
            </div>
        </div>
    </div>
</div>

<form id="formTransaksiTerpadu" method="POST" action="{{ route('transaksi-terpadu.store') }}">
    @csrf
    <input type="hidden" name="pelanggan_id" id="pelanggan_id" required>
    <input type="hidden" name="resep_mode" id="resep_mode" value="tidak_ada">
    <input type="hidden" name="resep_id" id="resep_id_input">

    {{-- ===================== TAHAP 1: PELANGGAN ===================== --}}
    <div class="tahap-form" id="tahap-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-user mr-2"></i>Langkah 1 — Cari atau Tambah Pelanggan
                </h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                        </div>
                        <input type="text" id="cariPelanggan" class="form-control border-left-0"
                               placeholder="Ketik nama atau no. telepon pelanggan..." autocomplete="off">
                    </div>
                    <div id="hasilCariPelanggan" class="list-group mt-1 shadow-sm" style="display:none; position:relative; z-index:100;"></div>
                    <small class="text-muted">Minimal 2 karakter untuk memulai pencarian</small>
                </div>

                <div id="pelangganTerpilih" style="display:none;" class="mt-3">
                    <div class="card border-success">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle-lg mr-3">
                                        <span id="avatarPelanggan"></span>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-success" id="namaPelangganTerpilih"></div>
                                        <div class="small text-muted" id="infoPelangganTerpilih"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnGantiPelanggan">
                                    <i class="fas fa-exchange-alt mr-1"></i>Ganti
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="text-center py-2">
                    <span class="text-muted small">Pelanggan baru yang belum pernah ke sini sebelumnya?</span><br>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                            data-toggle="collapse" data-target="#formPelangganBaru">
                        <i class="fas fa-user-plus mr-1"></i>Tambah Data Pelanggan Baru
                    </button>
                </div>

                <div class="collapse mt-3" id="formPelangganBaru">
                    <div class="card card-body" style="background:#f8fafc; border: 2px dashed #d0e4f7;">
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-user-plus mr-2"></i>Data Pelanggan Baru
                        </h6>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="newNama" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" id="newTelepon" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-muted small">(opsional)</span></label>
                                <input type="email" id="newEmail" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <input type="text" id="newAlamat" class="form-control">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="btnSimpanPelangganBaru">
                            <i class="fas fa-save mr-1"></i>Simpan & Pilih Pelanggan Ini
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right bg-white">
                <button type="button" class="btn btn-primary btn-lg" id="btnLanjutTahap2" disabled>
                    Lanjut ke Resep Mata <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== TAHAP 2: RESEP MATA ===================== --}}
    <div class="tahap-form" id="tahap-2">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-eye mr-2"></i>Langkah 2 — Resep Mata
                </h6>
            </div>
            <div class="card-body">
                <div id="riwayatResepWrapper" style="display:none;">
                    <h6 class="font-weight-bold mb-3">
                        <i class="fas fa-history mr-2 text-primary"></i>Riwayat Resep Pelanggan
                    </h6>
                    <div id="daftarRiwayatResep"></div>
                    <hr>
                </div>

                <div id="tanpaRiwayatResep" class="text-center py-4" style="display:none;">
                    <i class="fas fa-clipboard fa-3x text-gray-300 mb-3 d-block"></i>
                    <p class="text-muted">Pelanggan ini belum punya riwayat resep mata.</p>
                </div>

                <div class="d-flex mb-3" style="gap: 10px;">
                    <button type="button" class="btn btn-outline-primary" id="btnBuatResepBaru">
                        <i class="fas fa-plus mr-1"></i>Buat Resep Baru
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="btnTanpaResep">
                        <i class="fas fa-forward mr-1"></i>Lewati (Tidak Perlu Resep)
                    </button>
                </div>

                <div id="resepTerpilihInfo" class="alert alert-success" style="display:none;"></div>

                <div id="formResepBaru" style="display:none;" class="card card-body mt-3">
                    <h6 class="font-weight-bold text-primary mb-3">
                        <i class="fas fa-eye mr-2"></i>Input Resep Baru
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-body mb-3" style="border-left: 4px solid #1a3a5c;">
                                <h6 class="font-weight-bold mb-3">👁️ Mata Kanan (OD)</h6>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">SPH</label>
                                        <input type="number" step="0.25" name="od_sph" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">CYL</label>
                                        <input type="number" step="0.25" name="od_cyl" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">Axis</label>
                                        <input type="number" name="od_axis" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">Add</label>
                                        <input type="number" step="0.25" name="od_add" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-body mb-3" style="border-left: 4px solid #00b4d8;">
                                <h6 class="font-weight-bold mb-3">👁️ Mata Kiri (OS)</h6>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">SPH</label>
                                        <input type="number" step="0.25" name="os_sph" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">CYL</label>
                                        <input type="number" step="0.25" name="os_cyl" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">Axis</label>
                                        <input type="number" name="os_axis" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small font-weight-bold">Add</label>
                                        <input type="number" step="0.25" name="os_add" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">PD Kanan</label>
                            <input type="number" step="0.25" name="pd_kanan" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">PD Kiri</label>
                            <input type="number" step="0.25" name="pd_kiri" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Diperiksa Oleh</label>
                            <input type="text" name="dokter" class="form-control form-control-sm" placeholder="Opsional">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Catatan</label>
                            <input type="text" name="catatan_resep" class="form-control form-control-sm">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="btnSimpanResepForm">
                        <i class="fas fa-check mr-1"></i>Gunakan Resep Ini
                    </button>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between bg-white">
                <button type="button" class="btn btn-secondary" id="btnKembaliTahap1">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </button>
                <button type="button" class="btn btn-primary btn-lg" id="btnLanjutTahap3" disabled>
                    Lanjut ke Produk <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== TAHAP 3: PRODUK ===================== --}}
    <div class="tahap-form" id="tahap-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-glasses mr-2"></i>Langkah 3 — Pilih Produk
                </h6>
            </div>
            <div class="card-body">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="cekFrameSendiri">
                    <label class="custom-control-label font-weight-bold" for="cekFrameSendiri">
                        <i class="fas fa-glasses mr-1 text-info"></i>Pelanggan Bawa Frame Sendiri
                    </label>
                </div>

                <div id="ketFrameSendiriWrapper" style="display:none;" class="form-group ml-4">
                    <input type="text" id="ketFrameSendiri" class="form-control"
                           placeholder="Keterangan frame (opsional)">
                </div>

                <hr>

                <div class="form-row align-items-end">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Cari & Pilih Produk</label>
                        <input type="text" id="searchProduk" class="form-control mb-1"
                               placeholder="Ketik nama produk untuk filter...">
                        <select id="pilihProduk" class="form-control" size="4" style="height:auto;">
                            @foreach($produks as $p)
                                <option value="{{ $p->id }}"
                                        data-nama="{{ $p->nama_produk }}"
                                        data-harga="{{ $p->harga }}"
                                        data-stok="{{ $p->stok }}">
                                    [{{ ucfirst($p->kategori) }}] {{ $p->nama_produk }} — Rp {{ number_format($p->harga, 0, ',', '.') }} (Stok: {{ $p->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="font-weight-bold">Jumlah</label>
                        <input type="number" id="jumlahProduk" class="form-control" value="1" min="1">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="button" class="btn btn-primary btn-block" id="btnTambahItem">
                            <i class="fas fa-plus mr-1"></i>Tambah ke Keranjang
                        </button>
                    </div>
                </div>

                <table class="table table-bordered mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Item</th>
                            <th width="80" class="text-center">Jumlah</th>
                            <th width="140" class="text-right">Harga Satuan</th>
                            <th width="140" class="text-right">Subtotal</th>
                            <th width="50" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="daftarItemKeranjang">
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-shopping-cart fa-2x d-block mb-2 text-gray-300"></i>
                                Belum ada item ditambahkan
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="3" class="text-right">Total</th>
                            <th class="text-right" id="totalKeranjang">Rp 0</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between bg-white">
                <button type="button" class="btn btn-secondary" id="btnKembaliTahap2">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </button>
                <button type="button" class="btn btn-primary btn-lg" id="btnLanjutTahap4" disabled>
                    Lanjut ke Checkout <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== TAHAP 4: CHECKOUT ===================== --}}
    <div class="tahap-form" id="tahap-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-cash-register mr-2"></i>Langkah 4 — Checkout
                </h6>
            </div>
            <div class="card-body">
                <div class="card mb-4" style="border-left: 4px solid #1a3a5c;">
                    <div class="card-body py-3">
                        <h6 class="font-weight-bold mb-3">
                            <i class="fas fa-list mr-2 text-primary"></i>Ringkasan Item
                        </h6>
                        <table class="table table-sm mb-2" id="ringkasanItemTable"></table>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <strong>Subtotal</strong>
                            <strong id="ringkasanSubtotal">Rp 0</strong>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="form-control"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Metode Pembayaran</label>
                        <select name="metode_bayar" class="form-control" required>
                            <option value="tunai">💵 Tunai</option>
                            <option value="transfer">🏦 Transfer Bank</option>
                            <option value="qris">📱 QRIS</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">Diskon</label>
                        <div class="input-group">
                            <input type="number" name="diskon" id="inputDiskon"
                                   class="form-control" value="0" min="0">
                            <div class="input-group-append">
                                <select name="tipe_diskon" id="tipeDiskon" class="form-control"
                                        style="border-radius:0 8px 8px 0;">
                                    <option value="nominal">Rp</option>
                                    <option value="persen">%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">Grand Total</label>
                        <input type="text" id="grandTotalTampil"
                               class="form-control font-weight-bold text-primary" readonly
                               style="font-size:1.1rem;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tipe Pembayaran</label>
                    <div class="d-flex" style="gap:10px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="bayarLunas" name="tipe_bayar"
                                   value="lunas" class="custom-control-input" checked>
                            <label class="custom-control-label" for="bayarLunas">
                                <i class="fas fa-check-circle text-success mr-1"></i>Lunas
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="bayarDp" name="tipe_bayar"
                                   value="dp" class="custom-control-input">
                            <label class="custom-control-label" for="bayarDp">
                                <i class="fas fa-hand-holding-usd text-warning mr-1"></i>DP / Cicil
                            </label>
                        </div>
                    </div>
                </div>

                <div id="fieldLunas" class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Jumlah Dibayar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="bayar" id="inputBayar"
                                   class="form-control" min="0">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Kembalian</label>
                        <input type="text" id="kembalianTampil"
                               class="form-control text-success font-weight-bold" readonly>
                    </div>
                </div>

                <div id="fieldDp" class="form-row" style="display:none;">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Jumlah DP</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="dp" id="inputDp" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Catatan <span class="text-muted small">(opsional)</span></label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between bg-white">
                <button type="button" class="btn btn-secondary" id="btnKembaliTahap3">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </button>
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-check-circle mr-2"></i>Simpan Transaksi
                </button>
            </div>
        </div>
    </div>

    <div id="hiddenItemInputs"></div>
</form>

@endsection

@push('scripts')
<style>
    .step-item { display:flex; flex-direction:column; align-items:center; z-index:2; }
    .step-circle { width:44px; height:44px; border-radius:50%; background:#e8ecf0; color:#aaa; display:flex; align-items:center; justify-content:center; font-size:16px; transition:all 0.3s; border:3px solid #e8ecf0; }
    .step-item.active .step-circle { background:linear-gradient(135deg,#1a3a5c,#2d5f8a); color:white; border-color:#1a3a5c; box-shadow:0 4px 12px rgba(26,58,92,0.3); }
    .step-item.done .step-circle { background:#00b4d8; color:white; border-color:#00b4d8; }
    .step-label { font-size:0.72rem; margin-top:6px; color:#aaa; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; }
    .step-item.active .step-label { color:#1a3a5c; }
    .step-item.done .step-label { color:#00b4d8; }
    .step-line { flex:1; height:3px; background:#e8ecf0; margin:0 8px; margin-bottom:28px; border-radius:2px; transition:background 0.3s; }
    .step-line.done { background:#00b4d8; }
    .tahap-form { display:none; }
    .tahap-form.show { display:block; }
    #hasilCariPelanggan .list-group-item { cursor:pointer; transition:background 0.15s; }
    #hasilCariPelanggan .list-group-item:hover { background:#f0f7ff; }
    .avatar-circle-lg { width:45px; height:45px; background:linear-gradient(135deg,#1a3a5c,#2d5f8a); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:bold; flex-shrink:0; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tahap-1').classList.add('show');

    let pelangganTerpilihData = null;
    let riwayatResepData = [];
    let keranjang = [];
    let keranjangCounter = 0;

    function updateStepIndicator(activeStep) {
        document.querySelectorAll('.step-item').forEach(item => {
            const n = parseInt(item.dataset.step);
            item.classList.remove('active','done');
            if (n < activeStep) item.classList.add('done');
            else if (n === activeStep) item.classList.add('active');
        });
        document.querySelectorAll('.step-line').forEach((line, i) => {
            line.classList.toggle('done', i < activeStep - 1);
        });
    }

    // CARI PELANGGAN
    const inputCari = document.getElementById('cariPelanggan');
    const hasilCari = document.getElementById('hasilCariPelanggan');
    let timeoutCari;

    inputCari.addEventListener('input', function() {
        clearTimeout(timeoutCari);
        const keyword = this.value.trim();
        if (keyword.length < 2) { hasilCari.style.display = 'none'; return; }
        timeoutCari = setTimeout(() => {
            fetch(`{{ route('pelanggan.ajax-search') }}?q=${encodeURIComponent(keyword)}`)
                .then(r => r.json())
                .then(data => {
                    hasilCari.innerHTML = '';
                    if (data.length === 0) {
                        hasilCari.innerHTML = '<div class="list-group-item text-muted small py-2">Tidak ditemukan. Tambah sebagai pelanggan baru di bawah.</div>';
                    } else {
                        data.forEach(p => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = `<div class="d-flex align-items-center"><div style="width:32px;height:32px;font-size:13px;background:linear-gradient(135deg,#1a3a5c,#2d5f8a);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;flex-shrink:0;" class="mr-2">${p.nama.charAt(0).toUpperCase()}</div><div><div class="font-weight-bold small">${p.nama}</div><div class="text-muted" style="font-size:0.75rem;">${p.no_telepon}${p.alamat ? ' · '+p.alamat : ''}</div></div></div>`;
                            item.addEventListener('click', e => { e.preventDefault(); pilihPelanggan(p); });
                            hasilCari.appendChild(item);
                        });
                    }
                    hasilCari.style.display = 'block';
                });
        }, 350);
    });

    function pilihPelanggan(p) {
        pelangganTerpilihData = p;
        document.getElementById('pelanggan_id').value = p.id;
        document.getElementById('namaPelangganTerpilih').textContent = p.nama;
        document.getElementById('infoPelangganTerpilih').textContent = p.no_telepon + (p.alamat ? ' · '+p.alamat : '');
        document.getElementById('avatarPelanggan').textContent = p.nama.charAt(0).toUpperCase();
        document.getElementById('pelangganTerpilih').style.display = 'block';
        inputCari.value = '';
        inputCari.style.display = 'none';
        hasilCari.style.display = 'none';
        document.getElementById('btnLanjutTahap2').disabled = false;
        muatRiwayatResep(p.id);
    }

    document.getElementById('btnGantiPelanggan').addEventListener('click', function() {
        document.getElementById('pelanggan_id').value = '';
        document.getElementById('pelangganTerpilih').style.display = 'none';
        inputCari.style.display = 'block';
        inputCari.value = '';
        inputCari.focus();
        document.getElementById('btnLanjutTahap2').disabled = true;
    });

    document.getElementById('btnSimpanPelangganBaru').addEventListener('click', function() {
        const nama = document.getElementById('newNama').value.trim();
        const telepon = document.getElementById('newTelepon').value.trim();
        const email = document.getElementById('newEmail').value.trim();
        const alamat = document.getElementById('newAlamat').value.trim();
        if (!nama || !telepon || !alamat) { alert('Nama, Telepon, dan Alamat wajib diisi.'); return; }
        const fd = new FormData();
        fd.append('nama', nama); fd.append('no_telepon', telepon);
        fd.append('email', email); fd.append('alamat', alamat);
        fd.append('_token', '{{ csrf_token() }}');
        fetch('{{ route("pelanggan.ajax-store") }}', { method:'POST', body:fd })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    pilihPelanggan({ id:data.id, nama:data.nama, no_telepon:telepon, alamat });
                    document.getElementById('formPelangganBaru').classList.remove('show');
                }
            });
    });

    // RIWAYAT RESEP
    function muatRiwayatResep(id) {
        fetch(`/pelanggan/${id}/ajax-riwayat-resep`)
            .then(r => r.json())
            .then(data => { riwayatResepData = data; tampilkanRiwayatResep(data); });
    }

    function tampilkanRiwayatResep(data) {
        const wrapper = document.getElementById('riwayatResepWrapper');
        const tanpa   = document.getElementById('tanpaRiwayatResep');
        const daftar  = document.getElementById('daftarRiwayatResep');
        daftar.innerHTML = '';
        if (data.length === 0) { wrapper.style.display='none'; tanpa.style.display='block'; return; }
        tanpa.style.display = 'none'; wrapper.style.display = 'block';
        data.forEach(r => {
            const tgl = new Date(r.tanggal_periksa).toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'});
            const card = document.createElement('div');
            card.className = 'card mb-2 border-left-primary';
            card.innerHTML = `<div class="card-body py-2 px-3 d-flex justify-content-between align-items-center"><div><div class="font-weight-bold small text-primary"><i class="far fa-clock mr-1"></i>${tgl}</div><div class="small text-muted mt-1"><strong>OD:</strong> Sph ${fmt(r.od_sph)} Cyl ${fmt(r.od_cyl)} Axis ${r.od_axis??'-'}° &nbsp;|&nbsp; <strong>OS:</strong> Sph ${fmt(r.os_sph)} Cyl ${fmt(r.os_cyl)} Axis ${r.os_axis??'-'}°</div></div><button type="button" class="btn btn-sm btn-outline-primary btn-pilih-resep ml-3"><i class="fas fa-check mr-1"></i>Pilih</button></div>`;
            card.querySelector('.btn-pilih-resep').addEventListener('click', () => pilihResepLama(r, tgl));
            daftar.appendChild(card);
        });
    }

    function fmt(n) {
        if (n === null || n === undefined) return '-';
        return n > 0 ? '+'+parseFloat(n).toFixed(2) : parseFloat(n).toFixed(2);
    }

    function pilihResepLama(r, tgl) {
        document.getElementById('resep_mode').value = 'lama';
        document.getElementById('resep_id_input').value = r.id;
        document.getElementById('formResepBaru').style.display = 'none';
        const info = document.getElementById('resepTerpilihInfo');
        info.style.display = 'block';
        info.innerHTML = `<i class="fas fa-check-circle mr-2"></i>Memakai resep tanggal <strong>${tgl}</strong>`;
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
        info.innerHTML = '<i class="fas fa-info-circle mr-2"></i>Transaksi ini tanpa resep mata.';
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

    // SEARCH PRODUK
    document.getElementById('searchProduk').addEventListener('input', function() {
        const kw = this.value.toLowerCase();
        Array.from(document.getElementById('pilihProduk').options).forEach(opt => {
            opt.style.display = opt.text.toLowerCase().includes(kw) ? '' : 'none';
        });
    });

    // KERANJANG
    document.getElementById('cekFrameSendiri').addEventListener('change', function() {
        document.getElementById('ketFrameSendiriWrapper').style.display = this.checked ? 'block' : 'none';
        if (this.checked) {
            if (!keranjang.some(i => i.jenis === 'frame_sendiri')) {
                keranjang.push({ uid:keranjangCounter++, jenis:'frame_sendiri', nama:'Frame Milik Pelanggan', jumlah:1, harga:0, subtotal:0, keterangan:'' });
                renderKeranjang();
            }
        } else {
            keranjang = keranjang.filter(i => i.jenis !== 'frame_sendiri');
            renderKeranjang();
        }
    });

    document.getElementById('ketFrameSendiri').addEventListener('input', function() {
        const item = keranjang.find(i => i.jenis === 'frame_sendiri');
        if (item) item.keterangan = this.value;
    });

    document.getElementById('btnTambahItem').addEventListener('click', function() {
        const select = document.getElementById('pilihProduk');
        if (!select.value) { alert('Pilih produk terlebih dahulu.'); return; }
        const opt = select.options[select.selectedIndex];
        const jumlah = parseInt(document.getElementById('jumlahProduk').value) || 1;
        const stok = parseInt(opt.dataset.stok);
        if (jumlah > stok) { alert('Stok tidak cukup. Sisa stok: ' + stok); return; }
        const harga = parseFloat(opt.dataset.harga);
        keranjang.push({ uid:keranjangCounter++, jenis:'produk', produkId:select.value, nama:opt.dataset.nama, jumlah, harga, subtotal:harga*jumlah });
        renderKeranjang();
        select.selectedIndex = -1;
        document.getElementById('jumlahProduk').value = 1;
    });

    function hapusItem(uid) {
        const item = keranjang.find(i => i.uid === uid);
        if (item?.jenis === 'frame_sendiri') {
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
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-shopping-cart fa-2x d-block mb-2 text-gray-300"></i>Belum ada item</td></tr>';
            document.getElementById('totalKeranjang').textContent = 'Rp 0';
            document.getElementById('btnLanjutTahap4').disabled = true;
            return;
        }
        let total = 0;
        keranjang.forEach(item => {
            total += item.subtotal;
            const nama = item.jenis === 'frame_sendiri'
                ? `<span class="badge badge-info mr-1">Bawa Sendiri</span>${item.nama}${item.keterangan ? ' <span class="text-muted small">— '+item.keterangan+'</span>' : ''}`
                : item.nama;
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${nama}</td><td class="text-center">${item.jumlah}</td><td class="text-right">Rp ${item.harga.toLocaleString('id-ID')}</td><td class="text-right">Rp ${item.subtotal.toLocaleString('id-ID')}</td><td class="text-center"><button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>`;
            tr.querySelector('button').addEventListener('click', () => hapusItem(item.uid));
            tbody.appendChild(tr);
        });
        document.getElementById('totalKeranjang').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('btnLanjutTahap4').disabled = false;
    }

    // CHECKOUT
    function renderRingkasanCheckout() {
        const tbody = document.getElementById('ringkasanItemTable');
        tbody.innerHTML = '';
        let subtotal = 0;
        keranjang.forEach(item => {
            subtotal += item.subtotal;
            const tr = document.createElement('tr');
            const nama = item.jenis === 'frame_sendiri' ? item.nama+' (Bawa Sendiri)' : item.nama;
            tr.innerHTML = `<td>${nama} ×${item.jumlah}</td><td class="text-right font-weight-bold">Rp ${item.subtotal.toLocaleString('id-ID')}</td>`;
            tbody.appendChild(tr);
        });
        document.getElementById('ringkasanSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        hitungGrandTotal();
    }

    function hitungGrandTotal() {
        const subtotal = keranjang.reduce((s, i) => s + i.subtotal, 0);
        const diskon = document.getElementById('tipeDiskon').value === 'persen'
            ? subtotal * ((parseFloat(document.getElementById('inputDiskon').value)||0) / 100)
            : (parseFloat(document.getElementById('inputDiskon').value)||0);
        const gt = subtotal - diskon;
        document.getElementById('grandTotalTampil').value = 'Rp ' + gt.toLocaleString('id-ID');
        const inputBayar = document.getElementById('inputBayar');
        if (!inputBayar.dataset.diubahManual) inputBayar.value = gt;
        hitungKembalian(gt);
        return gt;
    }

    function hitungKembalian(gt) {
        const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
        const kembalian = bayar - gt;
        document.getElementById('kembalianTampil').value = 'Rp ' + (kembalian > 0 ? kembalian.toLocaleString('id-ID') : '0');
    }

    document.getElementById('inputDiskon').addEventListener('input', hitungGrandTotal);
    document.getElementById('tipeDiskon').addEventListener('change', hitungGrandTotal);
    document.getElementById('inputBayar').addEventListener('input', function() {
        this.dataset.diubahManual = 'true';
        hitungKembalian(hitungGrandTotal());
    });

    document.querySelectorAll('input[name="tipe_bayar"]').forEach(r => {
        r.addEventListener('change', function() {
            document.getElementById('fieldLunas').style.display = this.value === 'dp' ? 'none' : 'flex';
            document.getElementById('fieldDp').style.display   = this.value === 'dp' ? 'flex' : 'none';
        });
    });

    // NAVIGASI
    document.getElementById('btnLanjutTahap2').addEventListener('click', function() {
        document.getElementById('tahap-1').classList.remove('show');
        document.getElementById('tahap-2').classList.add('show');
        updateStepIndicator(2);
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
    document.getElementById('btnKembaliTahap2').addEventListener('click', function() {
        document.getElementById('tahap-3').classList.remove('show');
        document.getElementById('tahap-2').classList.add('show');
        updateStepIndicator(2);
    });
    document.getElementById('btnLanjutTahap4').addEventListener('click', function() {
        document.getElementById('tahap-3').classList.remove('show');
        document.getElementById('tahap-4').classList.add('show');
        delete document.getElementById('inputBayar').dataset.diubahManual;
        renderRingkasanCheckout();
        updateStepIndicator(4);
    });
    document.getElementById('btnKembaliTahap3').addEventListener('click', function() {
        document.getElementById('tahap-4').classList.remove('show');
        document.getElementById('tahap-3').classList.add('show');
        updateStepIndicator(3);
    });

    // SUBMIT
    document.getElementById('formTransaksiTerpadu').addEventListener('submit', function(e) {
        if (keranjang.length === 0) {
            e.preventDefault();
            alert('Belum ada item di keranjang.');
            return;
        }
        const container = document.getElementById('hiddenItemInputs');
        container.innerHTML = '';
        keranjang.forEach((item, i) => {
            const mk = (n, v) => {
                const el = document.createElement('input');
                el.type = 'hidden'; el.name = n; el.value = v;
                container.appendChild(el);
            };
            mk(`item_jenis[${i}]`, item.jenis);
            mk(`item_jumlah[${i}]`, item.jumlah);
            if (item.jenis === 'produk') {
                mk(`item_produk_id[${i}]`, item.produkId);
            } else {
                mk(`item_keterangan_frame[${i}]`, item.keterangan || '');
            }
        });
    });
});
</script>
@endpush