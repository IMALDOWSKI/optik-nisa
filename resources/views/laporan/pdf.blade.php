<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        h1 { font-size: 16px; text-align: center; margin-bottom: 4px; }
        .subtitle { text-align: center; font-size: 11px; color: #555; margin-bottom: 16px; }
        .ringkasan { display: flex; gap: 20px; margin-bottom: 16px; }
        .ringkasan-item { border: 1px solid #ddd; padding: 8px 14px; border-radius: 4px; flex: 1; }
        .ringkasan-item .label { font-size: 9px; text-transform: uppercase; color: #888; }
        .ringkasan-item .value { font-size: 13px; font-weight: bold; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead th {
            background: #1a3a5c;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
        }
        tbody td { padding: 5px 8px; font-size: 10px; border-bottom: 1px solid #eee; vertical-align: top; }
        tbody tr:nth-child(even) { background: #f8f9fa; }
        tfoot td { padding: 6px 8px; font-weight: bold; font-size: 11px; border-top: 2px solid #1a3a5c; }
        .badge-selesai { color: #155724; background: #d4edda; padding: 2px 6px; border-radius: 3px; }
        .badge-pending { color: #856404; background: #fff3cd; padding: 2px 6px; border-radius: 3px; }
        .badge-batal   { color: #721c24; background: #f8d7da; padding: 2px 6px; border-radius: 3px; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #888; }
    </style>
</head>
<body>

    <h1>{{ __('menu.laporan_transaksi') }}</h1>
    <div class="subtitle">
        {{ __('menu.periode') }}: {{ $daftarBulan[$bulan] }} {{ $tahun }} &nbsp;|&nbsp;
        {{ __('menu.dicetak') }}: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

    <div class="ringkasan">
        <div class="ringkasan-item">
<div class="label">{{ __('menu.total_transaksi') }}</div>
            <div class="value">{{ $transaksis->count() }}</div>
        </div>
        <div class="ringkasan-item">
        <div class="label">{{ __('menu.transaksi_selesai') }}</div>
            <div class="value">{{ $transaksis->where('status', 'selesai')->count() }}</div>
        </div>
        <div class="ringkasan-item">
        <div class="label">{{ __('menu.total_pendapatan') ?? 'Total Pendapatan' }}</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25">{{ __('menu.no') }}</th>
                <th width="120">Kode Transaksi</th>
                <th width="100">Pelanggan</th>
                <th>Produk</th>
                <th width="90" style="text-align:right">Total</th>
                <th width="70">Metode</th>
                <th width="70">Tanggal</th>
                <th width="65">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->pelanggan->nama }}</td>
                <td>
                    @foreach($t->details as $d)
                        <div>
                            @if($d->is_frame_sendiri)
                                Frame Milik Pelanggan{{ $d->keterangan_frame_sendiri ? ' ('.$d->keterangan_frame_sendiri.')' : '' }}
                            @else
                                {{ $d->produk->nama_produk ?? '-' }} ({{ $d->jumlah }}x)
                            @endif
                        </div>
                    @endforeach
                </td>
                <td style="text-align:right">Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($t->metode_bayar) }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                <td>
                    @if($t->status == 'selesai')
                        <span class="badge-selesai">Selesai</span>
                    @elseif($t->status == 'pending')
                        <span class="badge-pending">Pending</span>
                    @else
                        <span class="badge-batal">Batal</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding: 20px; color: #888;">
                    Tidak ada transaksi pada periode ini
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($transaksis->count() > 0)
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right">Total Pendapatan (Transaksi Selesai):</td>
                <td style="text-align:right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        OptiCore by IMALDOWSKI &copy; {{ date('Y') }}
    </div>

</body>
</html>