@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
    <div>
        <a href="{{ route('transaksi.edit', $transaksi) }}"
   class="btn btn-warning btn-sm shadow-sm mr-2">
    <i class="fas fa-edit"></i> Edit Transaksi
</a>
        <a href="{{ route('transaksi.struk', $transaksi) }}"
           class="btn btn-success btn-sm shadow-sm mr-2" target="_blank">
            <i class="fas fa-print"></i> Cetak Struk
        </a>
        @php
    $pesanWa = "Halo *" . $transaksi->pelanggan->nama . "*,\n\n"
             . "Terima kasih telah berbelanja di *Optik Nisa*! 🙏\n\n"
             . "📋 *Detail Transaksi:*\n"
             . "No. Transaksi: " . $transaksi->kode_transaksi . "\n"
             . "Tanggal: " . \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') . "\n"
             . "Total: Rp " . number_format($transaksi->grand_total, 0, ',', '.') . "\n"
             . "Status: " . ucfirst($transaksi->status) . "\n\n"
             . "Terima kasih! 😊";
@endphp

<a href="{{ \App\Helpers\WhatsappHelper::link($transaksi->pelanggan->no_telepon, $pesanWa) }}"
   target="_blank" class="btn btn-success btn-sm">
    <i class="fab fa-whatsapp mr-1"></i>Kirim via WhatsApp
</a>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-receipt mr-2"></i>{{ $transaksi->kode_transaksi }}
        </h6>
        <span class="badge badge-{{ $transaksi->status == 'selesai' ? 'success' : ($transaksi->status == 'pending' ? 'warning' : 'danger') }}">
            {{ ucfirst($transaksi->status) }}
        </span>
    </div>
<div class="row mb-4">
    <div class="col-md-3">
        <small class="text-muted d-block">Pelanggan</small>
        <strong>{{ $transaksi->pelanggan->nama }}</strong>
    </div>
    <div class="col-md-3">
        <small class="text-muted d-block">Tanggal Transaksi</small>
        <strong>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</strong>
    </div>
    <div class="col-md-3">
        <small class="text-muted d-block">Metode Pembayaran</small>
        <strong>{{ ucfirst($transaksi->metode_bayar) }}</strong>
    </div>
    <div class="col-md-3">
        <small class="text-muted d-block">Tipe Pembayaran</small>
        @if($transaksi->hutang)
            <span class="badge badge-warning">
                <i class="fas fa-hand-holding-usd mr-1"></i>DP / Cicil
            </span>
            <div class="small text-danger mt-1">
                Sisa: Rp {{ number_format($transaksi->hutang->sisa_hutang, 0, ',', '.') }}
            </div>
        @else
            <span class="badge badge-success">
                <i class="fas fa-check-circle mr-1"></i>Lunas
            </span>
        @endif
    </div>
</div>
{{-- Info Pembayaran --}}
<div class="col-md-4 mt-3 mt-md-0">
    <small class="text-muted d-block">Tipe Pembayaran</small>
    @if($transaksi->hutang)
        <span class="badge badge-warning">
            <i class="fas fa-hand-holding-usd mr-1"></i>DP / Cicil
        </span>
        <div class="small text-muted mt-1">
            Sisa hutang: <strong class="text-danger">Rp {{ number_format($transaksi->hutang->sisa_hutang, 0, ',', '.') }}</strong>
        </div>
    @else
        <span class="badge badge-success">
            <i class="fas fa-check-circle mr-1"></i>Lunas
        </span>
    @endif
</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
@foreach($transaksi->details as $d)
<tr>
    <td>
        @if($d->is_frame_sendiri)
            <span class="badge badge-info mr-1">Bawa Sendiri</span>
            Frame Milik Pelanggan
            @if($d->keterangan_frame_sendiri)
                <div class="small text-muted">{{ $d->keterangan_frame_sendiri }}</div>
            @endif
        @else
            {{ $d->produk->nama_produk ?? 'Produk tidak ditemukan' }}
        @endif
    </td>
    <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
    <td>{{ $d->jumlah }}</td>
    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
</tr>
@endforeach
                </tbody>
                <tfoot>
<tfoot>
    <tr class="bg-light">
        <th colspan="3" class="text-right">Subtotal</th>
        <th>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
    </tr>
    @if($transaksi->diskon > 0)
    <tr class="text-danger">
        <td colspan="3" class="text-right">Diskon</td>
        <td>- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
    </tr>
    @endif
    <tr class="bg-primary text-white">
        <th colspan="3" class="text-right">Grand Total</th>
        <th>Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}</th>
    </tr>
    @if($transaksi->metode_bayar == 'tunai')
    <tr>
        <td colspan="3" class="text-right">Bayar</td>
        <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right">Kembalian</td>
        <td>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
    </tr>
    @endif
</tfoot>
                </tfoot>
            </table>
        </div>

        @if($transaksi->catatan)
        <div class="mt-3">
            <small class="text-muted d-block">Catatan</small>
            <p>{{ $transaksi->catatan }}</p>
        </div>
        @endif

    </div>
</div>
@endsection