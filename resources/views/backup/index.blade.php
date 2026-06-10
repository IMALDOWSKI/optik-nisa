@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-database mr-2"></i>Backup Database
    </h1>
    <form action="{{ route('backup.buat') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary btn-sm shadow-sm"
                onclick="return confirm('Buat backup sekarang?')">
            <i class="fas fa-plus mr-1"></i>Buat Backup Sekarang
        </button>
    </form>
</div>

{{-- Info --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Total Backup
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ count($backups) }} File
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Backup Terakhir
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ count($backups) > 0 ? $backups[0]['tanggal'] : 'Belum ada' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Database
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ config('database.connections.mysql.database') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Panduan --}}
<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle mr-2"></i>
    <strong>Panduan Backup:</strong>
    Disarankan melakukan backup minimal <strong>1x seminggu</strong> atau sebelum melakukan perubahan besar pada sistem.
    File backup tersimpan di server dan bisa didownload kapan saja.
</div>

{{-- Daftar Backup --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list mr-2"></i>Daftar File Backup
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                    <tr>
                        <td>
                            <i class="fas fa-file-code mr-2 text-primary"></i>
                            {{ $backup['nama'] }}
                        </td>
                        <td>{{ $backup['ukuran'] }}</td>
                        <td>{{ $backup['tanggal'] }}</td>
                        <td>
                            <a href="{{ route('backup.download', ['file' => $backup['nama']]) }}"
                               class="btn btn-success btn-sm mr-1">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                            <form action="{{ route('backup.hapus') }}" method="POST"
                                  style="display:inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="file" value="{{ $backup['nama'] }}">
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus file backup ini?')">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="fas fa-database fa-3x mb-3 d-block text-gray-300"></i>
                            <h5>Belum Ada Backup</h5>
                            <p>Klik tombol <strong>"Buat Backup Sekarang"</strong> untuk membuat backup pertama!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection