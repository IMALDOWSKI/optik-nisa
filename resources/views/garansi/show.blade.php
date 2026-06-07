@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Garansi</h1>
    <a href="{{ route('garansi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shield-alt mr-2"></i>{{ $garansi->no_garansi }}
                </h6>
                <span class="badge badge-{{
                    $garansi->status == 'aktif' ? 'success' :
                    ($garansi->status == 'klaim' ? 'warning' : 'danger')
                }} px-3 py-2">
                    {{ ucfirst($garansi->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Pelanggan</td>
                                <td><strong>{{ $garansi->pelanggan->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Produk</td>
                                <td><strong>{{ $garansi->produk->nama_produk }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. Transaksi</td>
                                <td>
                                    <a href="{{ route('transaksi.show', $garansi->transaksi) }}">
                                        <code>{{ $garansi->transaksi->kode_transaksi }}</code>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Mulai</td>
                                <td>{{ \Carbon\Carbon::parse($garansi->tanggal_mulai)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Selesai</td>
                                <td>{{ \Carbon\Carbon::parse($garansi->tanggal_selesai)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Sisa</td>
                                <td>
                                    @if($garansi->status == 'aktif')
                                        <span class="badge badge-{{ $garansi->sisaHari() <= 7 ? 'warning' : 'success' }}">
                                            {{ $garansi->sisaHari() }} hari lagi
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($garansi->ketentuan)
                <hr>
                <h6 class="font-weight-bold">Ketentuan Garansi:</h6>
                <p class="text-muted">{{ $garansi->ketentuan }}</p>
                @endif

                @if($garansi->catatan_klaim)
                <hr>
                <h6 class="font-weight-bold text-warning">Catatan Klaim:</h6>
                <p class="text-muted">{{ $garansi->catatan_klaim }}</p>
                <small class="text-muted">
                    Diklaim pada: {{ \Carbon\Carbon::parse($garansi->tanggal_klaim)->format('d/m/Y') }}
                </small>
                @endif
            </div>
        </div>
    </div>

    {{-- Form Klaim --}}
    @if($garansi->status == 'aktif')
    <div class="col-md-4">
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Proses Klaim
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('garansi.klaim', $garansi) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Alasan Klaim</label>
                        <textarea name="catatan_klaim" class="form-control" rows="4"
                                  placeholder="Jelaskan kerusakan atau alasan klaim garansi..."
                                  required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block"
                            onclick="return confirm('Yakin ingin mengklaim garansi ini?')">
                        <i class="fas fa-tools mr-2"></i>Proses Klaim
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection