@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Supplier</h1>
    <a href="{{ route('supplier.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Nama Supplier <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}"
                               placeholder="Nama perusahaan supplier">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            No. Telepon <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="no_telepon"
                               class="form-control @error('no_telepon') is-invalid @enderror"
                               value="{{ old('no_telepon') }}"
                               placeholder="08xxxxxxxxxx">
                        @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               placeholder="email@supplier.com">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Kontak Person</label>
                        <input type="text" name="kontak_person"
                               class="form-control"
                               value="{{ old('kontak_person') }}"
                               placeholder="Nama PIC di supplier">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">
                            Alamat <span class="text-danger">*</span>
                        </label>
                        <textarea name="alamat"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Alamat lengkap supplier">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"
                                  placeholder="Opsional...">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Simpan Supplier
            </button>
        </form>
    </div>
</div>
@endsection