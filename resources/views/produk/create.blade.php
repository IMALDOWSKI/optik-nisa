@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <!-- Info Umum -->
            <h5 class="text-primary font-weight-bold mb-3">Informasi Umum</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}">
                        @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
    <div class="form-group">
        <label class="font-weight-bold">Barcode</label>
        <input type="text" name="barcode"
               class="form-control @error('barcode') is-invalid @enderror"
               value="{{ old('barcode') }}"
               placeholder="Scan atau ketik barcode">
        @error('barcode')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Opsional — bisa diisi nanti</small>
    </div>
</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" id="kategoriSelect" class="form-control @error('kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="kacamata" {{ old('kategori') == 'kacamata' ? 'selected' : '' }}>Frame / Kacamata</option>
                            <option value="lensa" {{ old('kategori') == 'lensa' ? 'selected' : '' }}>Lensa</option>
                            <option value="aksesoris" {{ old('kategori') == 'aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                        </select>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Merk</label>
                        <input type="text" name="merk" class="form-control" value="{{ old('merk') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}">
                        </div>
                        @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok') }}">
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Detail Frame -->
            <div id="detailFrame" style="display:none">
                <hr>
                <h5 class="text-primary font-weight-bold mb-3">Detail Frame</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Material</label>
                            <select name="material" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="Plastik">Plastik</option>
                                <option value="Metal">Metal</option>
                                <option value="Titanium">Titanium</option>
                                <option value="Kayu">Kayu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Ukuran</label>
                            <select name="ukuran" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Warna</label>
                            <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam, Gold">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="unisex">Unisex</option>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Lensa -->
            <div id="detailLensa" style="display:none">
                <hr>
                <h5 class="text-primary font-weight-bold mb-3">Detail Lensa</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Lensa</label>
                            <select name="jenis_lensa" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="Single Vision">Single Vision</option>
                                <option value="Bifocal">Bifocal</option>
                                <option value="Progressive">Progressive</option>
                                <option value="Photochromic">Photochromic</option>
                                <option value="Softlens">Softlens</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Indeks Lensa</label>
                            <select name="indeks_lensa" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="1.50">1.50 (Standard)</option>
                                <option value="1.56">1.56</option>
                                <option value="1.61">1.61 (Mid-index)</option>
                                <option value="1.67">1.67 (High-index)</option>
                                <option value="1.74">1.74 (Ultra High-index)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Coating</label>
                            <select name="coating" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="Anti Reflective">Anti Reflective</option>
                                <option value="Blue Ray">Blue Ray</option>
                                <option value="UV Protection">UV Protection</option>
                                <option value="Anti Scratch">Anti Scratch</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const kategoriSelect = document.getElementById('kategoriSelect');

    function toggleDetail() {
        const val = kategoriSelect.value;
        document.getElementById('detailFrame').style.display  = val === 'kacamata' ? 'block' : 'none';
        document.getElementById('detailLensa').style.display  = val === 'lensa'    ? 'block' : 'none';
    }

    kategoriSelect.addEventListener('change', toggleDetail);
    toggleDetail(); // jalankan saat halaman load
</script>
@endpush
@endsection