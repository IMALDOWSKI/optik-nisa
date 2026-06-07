@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Restok</h1>
    <a href="{{ route('restok.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box mr-2"></i>Form Restok Produk
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('restok.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    Produk <span class="text-danger">*</span>
                                </label>
                                <select name="produk_id" id="produkSelect"
                                        class="form-control @error('produk_id') is-invalid @enderror">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produks as $p)
                                        <option value="{{ $p->id }}"
                                            data-stok="{{ $p->stok }}"
                                            {{ old('produk_id') == $p->id ? 'selected' : '' }}>
                                            [{{ $p->kode_produk }}] {{ $p->nama_produk }}
                                            — Stok: {{ $p->stok }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('produk_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Info Stok Sekarang --}}
                        <div class="col-md-12">
                            <div id="infoStok" class="alert alert-info d-none">
                                <i class="fas fa-info-circle mr-2"></i>
                                Stok saat ini: <strong id="stokSekarang">0</strong> unit
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    Jumlah Tambah <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="jumlah_tambah"
                                       id="jumlahTambah"
                                       class="form-control @error('jumlah_tambah') is-invalid @enderror"
                                       value="{{ old('jumlah_tambah') }}"
                                       min="1" placeholder="0">
                                @error('jumlah_tambah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Stok Setelah Restok</label>
                                <input type="text" id="stokSesudah"
                                       class="form-control bg-light"
                                       readonly placeholder="Otomatis terhitung">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Restok <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_restok"
                                       class="form-control"
                                       value="{{ old('tanggal_restok', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Harga Beli per Unit</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" name="harga_beli"
                                           class="form-control"
                                           value="{{ old('harga_beli') }}"
                                           placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Supplier</label>
                                <input type="text" name="supplier"
                                       class="form-control"
                                       value="{{ old('supplier') }}"
                                       placeholder="Nama supplier/toko">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">No. Faktur</label>
                                <input type="text" name="no_faktur"
                                       class="form-control"
                                       value="{{ old('no_faktur') }}"
                                       placeholder="Nomor faktur pembelian">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Catatan</label>
                                <textarea name="catatan" class="form-control"
                                          rows="2"
                                          placeholder="Opsional...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Simpan Restok
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Info Panduan --}}
    <div class="col-md-4">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-body">
                <h6 class="font-weight-bold text-info">
                    <i class="fas fa-info-circle mr-2"></i>Panduan Restok
                </h6>
                <ul class="small text-muted mt-2">
                    <li class="mb-2">Pilih produk yang ingin ditambah stoknya</li>
                    <li class="mb-2">Masukkan jumlah barang yang datang</li>
                    <li class="mb-2">Stok akan otomatis bertambah setelah disimpan</li>
                    <li class="mb-2">Isi harga beli untuk pencatatan keuntungan</li>
                    <li class="mb-2">No. Faktur untuk arsip pembelian</li>
                </ul>
            </div>
        </div>

        {{-- Produk Stok Rendah --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Perlu Restok
                </h6>
            </div>
            <div class="card-body p-0">
                @forelse(\App\Models\Produk::where('stok', '<=', 5)->where('status', 'aktif')->orderBy('stok')->get() as $s)
                <div class="d-flex align-items-center p-2 border-bottom">
                    <span class="badge badge-{{ $s->stok == 0 ? 'danger' : 'warning' }} mr-2">
                        {{ $s->stok }}
                    </span>
                    <small>{{ $s->nama_produk }}</small>
                </div>
                @empty
                <div class="text-center text-muted py-3">
                    <i class="fas fa-check-circle text-success"></i>
                    Semua stok aman!
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const produkSelect  = document.getElementById('produkSelect');
    const jumlahTambah  = document.getElementById('jumlahTambah');
    const stokSesudah   = document.getElementById('stokSesudah');
    const stokSekarang  = document.getElementById('stokSekarang');
    const infoStok      = document.getElementById('infoStok');

    function hitungStok() {
        const stok    = parseInt(produkSelect.options[produkSelect.selectedIndex]?.dataset.stok) || 0;
        const tambah  = parseInt(jumlahTambah.value) || 0;
        stokSesudah.value = tambah > 0 ? (stok + tambah) + ' unit' : '';
    }

    produkSelect.addEventListener('change', function() {
        const stok = this.options[this.selectedIndex]?.dataset.stok;
        if (stok !== undefined) {
            infoStok.classList.remove('d-none');
            stokSekarang.innerText = stok;
        } else {
            infoStok.classList.add('d-none');
        }
        hitungStok();
    });

    jumlahTambah.addEventListener('input', hitungStok);
</script>
@endpush
@endsection