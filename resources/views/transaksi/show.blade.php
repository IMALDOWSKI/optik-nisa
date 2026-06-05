@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ $transaksi->kode_transaksi }}</h6>
        <span class="badge badge-{{ $transaksi->status == 'selesai' ? 'success' : 'warning' }}">
            {{ ucfirst($transaksi->status) }}
        </span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <strong>Pelanggan:</strong> {{ $transaksi->pelanggan->nama }}
            </div>
            <div class="col-md-4">
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}
            </div>
            <div class="col-md-4">
                <strong>Metode Bayar:</strong> {{ ucfirst($transaksi->metode_bayar) }}
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
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
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
            </table>
        </div>

        @if($transaksi->catatan)
        <p><strong>Catatan:</strong> {{ $transaksi->catatan }}</p>
        @endif
    </div>
</div>
@endsection