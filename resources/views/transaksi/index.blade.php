@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Transaksi Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Metode Bayar</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $t)
                    <tr>
                        <td><code>{{ $t->kode_transaksi }}</code></td>
                        <td>{{ $t->pelanggan->nama }}</td>
                        <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($t->metode_bayar) }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $t->status == 'selesai' ? 'success' : ($t->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('transaksi.show', $t) }}"
                               class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('transaksi.struk', $t) }}"
                               class="btn btn-success btn-sm" target="_blank" title="Cetak Struk">
                                <i class="fas fa-print"></i>
                            </a>
                            <form action="{{ route('transaksi.destroy', $t) }}"
                                  method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus? Stok akan dikembalikan!')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $transaksis->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection