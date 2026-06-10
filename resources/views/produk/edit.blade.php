@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('produk.update', $produk) }}" method="POST">
            @csrf @method('PUT')

            {{-- Info Umum --}}
            <h5 class="text-primary font-weight-bold mb-3">Informasi Umum</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode Produk</label>
                        <input type="text" class="form-control bg-light"
                               value="{{ $produk->kode_produk }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
    <div class="form-group">
        <label class="font-weight-bold">Barcode</label>
        <input type="text" name="barcode"
               class="form-control @error('barcode') is-invalid @enderror"
               value="{{ old('barcode', $produk->barcode) }}"
               placeholder="Scan atau ketik barcode">
        @error('barcode')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_produk"
                               class="form-control @error('nama_produk') is-invalid @enderror"
                               value="{{ old('nama_produk', $produk->nama_produk) }}">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="kategori" id="kategoriSelect"
                                class="form-control @error('kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="kacamata"
                                {{ old('kategori', $produk->kategori) == 'kacamata' ? 'selected' : '' }}>
                                Frame / Kacamata
                            </option>
                            <option value="lensa"
                                {{ old('kategori', $produk->kategori) == 'lensa' ? 'selected' : '' }}>
                                Lensa
                            </option>
                            <option value="aksesoris"
                                {{ old('kategori', $produk->kategori) == 'aksesoris' ? 'selected' : '' }}>
                                Aksesoris
                            </option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Merk</label>
                        <input type="text" name="merk" class="form-control"
                               value="{{ old('merk', $produk->merk) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Harga <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="harga"
                                   class="form-control @error('harga') is-invalid @enderror"
                                   value="{{ old('harga', $produk->harga) }}">
                        </div>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Stok <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="stok"
                               class="form-control @error('stok') is-invalid @enderror"
                               value="{{ old('stok', $produk->stok) }}">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="aktif"
                                {{ old('status', $produk->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="nonaktif"
                                {{ old('status', $produk->status) == 'nonaktif' ? 'selected' : '' }}>
                                Non Aktif
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"
                                  rows="2">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Detail Frame --}}
            <div id="detailFrame" style="display:none">
                <hr>
                <h5 class="text-primary font-weight-bold mb-3">Detail Frame</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Material</label>
                            <select name="material" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Plastik','Metal','Titanium','Kayu'] as $m)
                                    <option value="{{ $m }}"
                                        {{ old('material', $produk->material) == $m ? 'selected' : '' }}>
                                        {{ $m }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Ukuran</label>
                            <select name="ukuran" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Small','Medium','Large'] as $u)
                                    <option value="{{ $u }}"
                                        {{ old('ukuran', $produk->ukuran) == $u ? 'selected' : '' }}>
                                        {{ $u }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Warna</label>
                            <input type="text" name="warna" class="form-control"
                                   value="{{ old('warna', $produk->warna) }}"
                                   placeholder="Contoh: Hitam, Gold">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Gender</label>
                            <select name="gender" class="form-control">
                                @foreach(['unisex','pria','wanita'] as $g)
                                    <option value="{{ $g }}"
                                        {{ old('gender', $produk->gender) == $g ? 'selected' : '' }}>
                                        {{ ucfirst($g) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Lensa --}}
            <div id="detailLensa" style="display:none">
                <hr>
                <h5 class="text-success font-weight-bold mb-3">Detail Lensa</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Jenis Lensa</label>
                            <select name="jenis_lensa" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Single Vision','Bifocal','Progressive','Photochromic','Softlens'] as $j)
                                    <option value="{{ $j }}"
                                        {{ old('jenis_lensa', $produk->jenis_lensa) == $j ? 'selected' : '' }}>
                                        {{ $j }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Indeks Lensa</label>
                            <select name="indeks_lensa" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['1.50','1.56','1.61','1.67','1.74'] as $idx)
                                    <option value="{{ $idx }}"
                                        {{ old('indeks_lensa', $produk->indeks_lensa) == $idx ? 'selected' : '' }}>
                                        {{ $idx }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Coating</label>
                            <select name="coating" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Anti Reflective','Blue Ray','UV Protection','Anti Scratch'] as $c)
                                    <option value="{{ $c }}"
                                        {{ old('coating', $produk->coating) == $c ? 'selected' : '' }}>
                                        {{ $c }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Update Produk
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const kategoriSelect = document.getElementById('kategoriSelect');

    function toggleDetail() {
        const val = kategoriSelect.value;
        document.getElementById('detailFrame').style.display =
            val === 'kacamata' ? 'block' : 'none';
        document.getElementById('detailLensa').style.display =
            val === 'lensa' ? 'block' : 'none';
    }

    kategoriSelect.addEventListener('change', toggleDetail);
    toggleDetail(); // jalankan saat halaman load
</script>
@endpush
@endsection