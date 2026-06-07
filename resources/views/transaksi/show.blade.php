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
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <small class="text-muted d-block">Pelanggan</small>
                <strong>{{ $transaksi->pelanggan->nama }}</strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Tanggal Transaksi</small>
                <strong>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</strong>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Metode Pembayaran</small>
                <strong>{{ ucfirst($transaksi->metode_bayar) }}</strong>
            </div>
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
                        <td>{{ $d->produk->nama_produk }}</td>
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