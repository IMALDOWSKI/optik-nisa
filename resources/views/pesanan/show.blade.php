@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pesanan</h1>
    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@php $label = $pesanan->labelStatus(); @endphp

<div class="row">
    <div class="col-md-8">

        {{-- Info Pesanan --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box mr-2"></i>{{ $pesanan->kode_pesanan }}
                </h6>
                <span class="badge badge-{{ $label['color'] }} px-3 py-2">
                    {{ $label['label'] }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Pelanggan</td>
                                <td><strong>{{ $pesanan->pelanggan->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. HP</td>
                                <td>{{ $pesanan->pelanggan->no_telepon }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Transaksi</td>
                                <td>
                                    <a href="{{ route('transaksi.show', $pesanan->transaksi) }}">
                                        <code>{{ $pesanan->transaksi->kode_transaksi }}</code>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Dibuat</td>
                                <td>{{ $pesanan->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Estimasi Selesai</td>
                                <td>
                                    @if($pesanan->tanggal_estimasi)
                                        {{ \Carbon\Carbon::parse($pesanan->tanggal_estimasi)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Selesai</td>
                                <td>
                                    @if($pesanan->tanggal_selesai)
                                        {{ \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($pesanan->catatan)
                <div class="alert alert-info mt-2">
                    <i class="fas fa-sticky-note mr-2"></i>
                    <strong>Catatan:</strong> {{ $pesanan->catatan }}
                </div>
                @endif

                @if($pesanan->catatan_internal)
                <div class="alert alert-warning mt-2">
                    <i class="fas fa-lock mr-2"></i>
                    <strong>Catatan Internal:</strong> {{ $pesanan->catatan_internal }}
                </div>
                @endif
            </div>
        </div>

        {{-- Detail Produk yang Dipesan --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shopping-bag mr-2"></i>Produk Dipesan
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->transaksi->details as $d)
                        <tr>
                            <td>{{ $d->produk->nama_produk }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Timeline Riwayat Status --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history mr-2"></i>Riwayat Status
                </h6>
            </div>
            <div class="card-body">
                @foreach($pesanan->riwayats->sortByDesc('created_at') as $r)
                @php $rl = (new \App\Models\Pesanan(['status' => $r->status]))->labelStatus(); @endphp
                <div class="d-flex mb-3">
                    <div class="mr-3">
                        <span class="badge badge-{{ $rl['color'] }} p-2">
                            <i class="fas fa-circle"></i>
                        </span>
                    </div>
                    <div>
                        <div class="font-weight-bold">{{ $rl['label'] }}</div>
                        @if($r->keterangan)
                            <div class="text-muted small">{{ $r->keterangan }}</div>
                        @endif
                        <div class="text-muted small">
                            {{ $r->created_at->format('d/m/Y H:i') }} —
                            {{ $r->user->name }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Update Status --}}
    @if($pesanan->status != 'sudah_diambil')
    <div class="col-md-4">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit mr-2"></i>Update Status
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.update-status', $pesanan) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Status Baru</label>
                        <select name="status" class="form-control">
                            @foreach([
                                'menunggu'       => 'Menunggu',
                                'diproses'       => 'Diproses',
                                'selesai_dibuat' => 'Selesai Dibuat',
                                'siap_diambil'   => 'Siap Diambil',
                                'sudah_diambil'  => 'Sudah Diambil',
                            ] as $val => $txt)
                                <option value="{{ $val }}"
                                    {{ $pesanan->status == $val ? 'selected' : '' }}>
                                    {{ $txt }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"
                                  placeholder="Contoh: Lensa sudah datang dari Jakarta..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection