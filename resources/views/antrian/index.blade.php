@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-ticket-alt mr-2"></i>Antrian Digital
    </h1>
    <div>
        <a href="{{ route('antrian.display') }}" target="_blank" class="btn btn-info btn-sm shadow-sm">
            <i class="fas fa-tv mr-1"></i>Buka Display
        </a>
        <form action="{{ route('antrian.reset') }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                    onclick="return confirm('Reset semua antrian hari ini?')">
                <i class="fas fa-redo mr-1"></i>Reset Antrian
            </button>
        </form>
    </div>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Sedang Dilayani
                </div>
                <div class="h3 font-weight-bold text-gray-800">
                    {{ $sedangDilayani ? '#' . $sedangDilayani->nomor_antrian : '-' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Menunggu
                </div>
                <div class="h3 font-weight-bold text-gray-800">
                    {{ $totalMenunggu }} Orang
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Sudah Dilayani
                </div>
                <div class="h3 font-weight-bold text-gray-800">
                    {{ $totalSelesai }} Orang
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Form Tambah Antrian --}}
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-plus mr-2"></i>Ambil Nomor Antrian
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('antrian.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control"
                               placeholder="Opsional...">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Keperluan</label>
                        <select name="keperluan" class="form-control">
                            <option value="kontrol_mata">👁️ Kontrol Mata</option>
                            <option value="beli_produk">🛒 Beli Produk</option>
                            <option value="ambil_pesanan">👓 Ambil Pesanan</option>
                            <option value="konsultasi">💬 Konsultasi</option>
                            <option value="lainnya">📌 Lainnya</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-ticket-alt mr-2"></i>Ambil Nomor Antrian
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Antrian --}}
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Daftar Antrian Hari Ini
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Keperluan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrians as $a)
                            @php $label = $a->labelStatus(); @endphp
                            <tr class="{{ $a->status == 'dipanggil' ? 'table-warning' : '' }}">
                                <td><h5 class="mb-0 font-weight-bold">{{ $a->nomor_antrian }}</h5></td>
                                <td>{{ $a->nama_pelanggan ?? '-' }}</td>
                                <td>{{ $a->labelKeperluan() }}</td>
                                <td>
                                    <span class="badge badge-{{ $label['color'] }}">
                                        {{ $label['label'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($a->status == 'menunggu')
                                        <form action="{{ route('antrian.panggil', $a) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button class="btn btn-warning btn-sm">
                                                <i class="fas fa-bullhorn mr-1"></i>Panggil
                                            </button>
                                        </form>
                                    @elseif($a->status == 'dipanggil')
                                        <form action="{{ route('antrian.selesai', $a) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm">
                                                <i class="fas fa-check mr-1"></i>Selesai
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($a->status, ['menunggu', 'dipanggil']))
                                        <form action="{{ route('antrian.batal', $a) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Batalkan antrian ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-ticket-alt fa-2x mb-2 d-block"></i>
                                    Belum ada antrian hari ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection