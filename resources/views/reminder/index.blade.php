@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-bell mr-2"></i>Reminder Kontrol Mata
    </h1>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Belum Pernah Periksa
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $belumPernahPeriksa->count() }} Pelanggan
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Lebih dari 1 Tahun
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $lebihSatuTahun->count() }} Pelanggan
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    6 - 12 Bulan
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $enamHingga12Bulan->count() }} Pelanggan
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pelanggan Lebih dari 1 Tahun --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-danger text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Lebih dari 1 Tahun Tidak Kontrol Mata
            <span class="badge badge-light ml-2">{{ $lebihSatuTahun->count() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Terakhir Periksa</th>
                        <th>Sudah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lebihSatuTahun as $p)
                    @php
                        $resepTerakhir = $p->resepMatas->first();
                    @endphp
                    <tr>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>
                            {{ $resepTerakhir
                                ? \Carbon\Carbon::parse($resepTerakhir->tanggal_periksa)->format('d/m/Y')
                                : '-' }}
                        </td>
                        <td>
                            <span class="badge badge-danger">
                                {{ $resepTerakhir
                                    ? \Carbon\Carbon::parse($resepTerakhir->tanggal_periksa)->diffForHumans()
                                    : '-' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pelanggan.riwayat', $p) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye mr-1"></i>Riwayat
                            </a>
                            <a href="{{ route('resep.create') }}?pelanggan_id={{ $p->id }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>Buat Resep
                            </a>
                            @php
    $pesanReminder = "Halo *" . $p->nama . "*,\n\n"
                   . "Kami dari *Optik Nisa* ingin mengingatkan bahwa sudah waktunya untuk kontrol mata kembali. 👁️\n\n"
                   . "Kontrol mata rutin penting untuk menjaga kesehatan mata Anda.\n\n"
                   . "Silakan kunjungi toko kami untuk pemeriksaan mata gratis!\n\n"
                   . "Terima kasih 😊 - Optik Nisa";
@endphp

<a href="{{ \App\Helpers\WhatsappHelper::link($p->no_telepon, $pesanReminder) }}"
   target="_blank" class="btn btn-success btn-sm">
    <i class="fab fa-whatsapp"></i>
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Semua pelanggan sudah kontrol dalam 1 tahun terakhir!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pelanggan 6-12 Bulan --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-clock mr-2"></i>
            6 - 12 Bulan Tidak Kontrol Mata
            <span class="badge badge-light ml-2">{{ $enamHingga12Bulan->count() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Terakhir Periksa</th>
                        <th>Sudah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enamHingga12Bulan as $p)
                    @php
                        $resepTerakhir = $p->resepMatas->first();
                    @endphp
                    <tr>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>
                            {{ $resepTerakhir
                                ? \Carbon\Carbon::parse($resepTerakhir->tanggal_periksa)->format('d/m/Y')
                                : '-' }}
                        </td>
                        <td>
                            <span class="badge badge-warning">
                                {{ $resepTerakhir
                                    ? \Carbon\Carbon::parse($resepTerakhir->tanggal_periksa)->diffForHumans()
                                    : '-' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pelanggan.riwayat', $p) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye mr-1"></i>Riwayat
                            </a>
                            <a href="{{ route('resep.create') }}?pelanggan_id={{ $p->id }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>Buat Resep
                            </a>
                            @php
    $pesanReminder = "Halo *" . $p->nama . "*,\n\n"
                   . "Kami dari *Optik Nisa* ingin mengingatkan bahwa sudah waktunya untuk kontrol mata kembali. 👁️\n\n"
                   . "Kontrol mata rutin penting untuk menjaga kesehatan mata Anda.\n\n"
                   . "Silakan kunjungi toko kami untuk pemeriksaan mata gratis!\n\n"
                   . "Terima kasih 😊 - Optik Nisa";
@endphp

<a href="{{ \App\Helpers\WhatsappHelper::link($p->no_telepon, $pesanReminder) }}"
   target="_blank" class="btn btn-success btn-sm">
    <i class="fab fa-whatsapp"></i>
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Tidak ada pelanggan dalam kategori ini!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Belum Pernah Periksa --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary">
            <i class="fas fa-user-times mr-2"></i>
            Belum Pernah Periksa Mata
            <span class="badge badge-secondary ml-2">{{ $belumPernahPeriksa->count() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Bergabung Sejak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($belumPernahPeriksa as $p)
                    <tr>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('resep.create') }}?pelanggan_id={{ $p->id }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i>Buat Resep
                            </a>
                            @php
    $pesanReminder = "Halo *" . $p->nama . "*,\n\n"
                   . "Kami dari *Optik Nisa* ingin mengingatkan bahwa sudah waktunya untuk kontrol mata kembali. 👁️\n\n"
                   . "Kontrol mata rutin penting untuk menjaga kesehatan mata Anda.\n\n"
                   . "Silakan kunjungi toko kami untuk pemeriksaan mata gratis!\n\n"
                   . "Terima kasih 😊 - Optik Nisa";
@endphp

<a href="{{ \App\Helpers\WhatsappHelper::link($p->no_telepon, $pesanReminder) }}"
   target="_blank" class="btn btn-success btn-sm">
    <i class="fab fa-whatsapp"></i>
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Semua pelanggan sudah pernah periksa mata!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection