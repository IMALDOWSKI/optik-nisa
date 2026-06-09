@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Hutang</h1>
    <a href="{{ route('hutang.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-7">

        {{-- Info Hutang --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>Informasi Hutang
                </h6>
                <span class="badge badge-{{ $hutang->status == 'lunas' ? 'success' : 'danger' }} px-3 py-2">
                    {{ $hutang->status == 'lunas' ? '✅ Lunas' : '⚠️ Belum Lunas' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Pelanggan</td>
                                <td><strong>{{ $hutang->pelanggan->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. Transaksi</td>
                                <td>
                                    <a href="{{ route('transaksi.show', $hutang->transaksi) }}">
                                        <code>{{ $hutang->transaksi->kode_transaksi }}</code>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jatuh Tempo</td>
                                <td>
                                    {{ $hutang->jatuh_tempo
                                        ? \Carbon\Carbon::parse($hutang->jatuh_tempo)->format('d/m/Y')
                                        : '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">Total Tagihan</td>
                                <td>
                                    <strong>
                                        Rp {{ number_format($hutang->total_tagihan, 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Sudah Bayar</td>
                                <td class="text-success font-weight-bold">
                                    Rp {{ number_format($hutang->total_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Sisa Hutang</td>
                                <td class="text-danger font-weight-bold">
                                    Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Progress Pembayaran --}}
                @php
                    $progress = $hutang->total_tagihan > 0
                        ? ($hutang->total_bayar / $hutang->total_tagihan) * 100
                        : 0;
                @endphp
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="font-weight-bold">Progress Pembayaran</small>
                        <small class="font-weight-bold">{{ number_format($progress, 0) }}%</small>
                    </div>
                    <div class="progress" style="height: 12px; border-radius: 6px;">
                        <div class="progress-bar bg-{{ $progress >= 100 ? 'success' : 'warning' }}"
                             style="width: {{ $progress }}%; border-radius: 6px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Pembayaran --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history mr-2"></i>Riwayat Pembayaran
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah Bayar</th>
                            <th>Metode</th>
                            <th>Dicatat Oleh</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hutang->pembayarans as $p)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}
                            </td>
                            <td class="text-success font-weight-bold">
                                Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ ucfirst($p->metode_bayar) }}
                                </span>
                            </td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->catatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Belum ada pembayaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($hutang->pembayarans->count() > 0)
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td>Total Dibayar</td>
                            <td class="text-success">
                                Rp {{ number_format($hutang->total_bayar, 0, ',', '.') }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

    </div>

    {{-- Form Bayar --}}
    <div class="col-md-5">
        @if($hutang->status == 'belum_lunas')
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-money-bill-wave mr-2"></i>Catat Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('hutang.bayar', $hutang) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Jumlah Bayar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="jumlah_bayar"
                                   class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                   max="{{ $hutang->sisa_hutang }}"
                                   placeholder="Maks: Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }}">
                        </div>
                        @error('jumlah_bayar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted">
                            Sisa hutang:
                            <strong>Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }}</strong>
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar"
                               class="form-control"
                               value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Metode Bayar</label>
                        <select name="metode_bayar" class="form-control">
                            <option value="tunai">💵 Tunai</option>
                            <option value="transfer">🏦 Transfer</option>
                            <option value="qris">📱 QRIS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control"
                                  rows="2" placeholder="Opsional..."></textarea>
                    </div>

                    {{-- Tombol Lunas Sekaligus --}}
                    <button type="button" class="btn btn-outline-success btn-sm btn-block mb-3"
                            id="btnLunasSekaligus">
                        <i class="fas fa-check-double mr-1"></i>
                        Lunas Sekaligus
                        (Rp {{ number_format($hutang->sisa_hutang, 0, ',', '.') }})
                    </button>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-save mr-2"></i>Simpan Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card shadow mb-4 border-left-success">
            <div class="card-body text-center py-4">
                <i class="fas fa-check-circle text-success fa-3x mb-3 d-block"></i>
                <h5 class="text-success font-weight-bold">Hutang Sudah Lunas!</h5>
                <p class="text-muted">Semua pembayaran sudah diselesaikan.</p>
            </div>
        </div>
        @endif

        {{-- Info Transaksi --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-receipt mr-2"></i>Info Transaksi
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hutang->transaksi->details as $d)
                        <tr>
                            <td>{{ $d->produk->nama_produk }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="2">Grand Total</td>
                            <td>
                                Rp {{ number_format($hutang->transaksi->grand_total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.getElementById('btnLunasSekaligus')?.addEventListener('click', function() {
        document.querySelector('input[name="jumlah_bayar"]').value = {{ $hutang->sisa_hutang }};
    });
</script>
@endpush

@endsection