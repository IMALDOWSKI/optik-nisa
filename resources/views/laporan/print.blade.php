<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Transaksi - Optik Nisa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            padding: 20px;
            color: #333;
        }

        .toolbar {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .toolbar h5 { flex: 1; color: #1a3a5c; margin: 0; }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-success   { background: #28a745; }
        .btn-secondary { background: #6c757d; }

        .laporan-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .kop {
            text-align: center;
            border-bottom: 3px solid #1a3a5c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .kop h2 {
            color: #1a3a5c;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .kop p { color: #666; font-size: 13px; }

        .periode {
            text-align: center;
            margin-bottom: 20px;
        }

        .periode h4 { color: #333; }

        .ringkasan {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 25px;
            padding: 15px;
            background: #f0f7ff;
            border-radius: 8px;
        }

        .ringkasan-item { text-align: center; }
        .ringkasan-item .label { font-size: 12px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        .ringkasan-item .value { font-size: 20px; font-weight: bold; color: #1a3a5c; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }

        table th {
            background: #1a3a5c;
            color: white;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        table tbody tr:nth-child(even) { background: #f8f9fa; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer-print {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .badge-selesai  { background: #28a745; }
        .badge-pending  { background: #ffc107; color: #333; }
        .badge-batal    { background: #dc3545; }

        @media print {
            body { background: white; padding: 0; }
            .toolbar { display: none; }
            .laporan-container { box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body>

<div class="toolbar">
<h5>{{ __('menu.preview_cetak_laporan_transaksi') }}</h5>
        <button class="btn btn-success" onclick="window.print()">
        {{ __('menu.print_sekarang') }}
    </button>
    <a href="{{ route('laporan.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-secondary">
        {{ __('menu.kembali') }}
    </a>
</div>


<div class="laporan-container">

    <div class="kop">
        <h2>OPTIK NISA</h2>

        <p>{{ __('menu.laporan_transaksi_penjualan') }}</p>

    </div>

    <div class="periode">
        <h4>Periode: {{ $daftarBulan[$bulan] }} {{ $tahun }}</h4>
    </div>

            <div class="ringkasan">
        <div class="ringkasan-item">
            <div class="label">{{ __('menu.total_transaksi') }}</div>
            <div class="value">{{ $transaksis->count() }}</div>
        </div>

        <div class="ringkasan-item">
            <div class="label">{{ __('menu.total_pendapatan') }}</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">{{ __('menu.total_diskon_diberikan') }}</div>
            <div class="value">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</div>
        </div>
    </div>


    <table>
        <thead>
            <tr>
                <th>{{ __('menu.no') }}</th>
                <th>{{ __('menu.kode_transaksi') }}</th>
                <th>{{ __('menu.pelanggan') }}</th>
                <th>{{ __('menu.tanggal') }}</th>
                <th>{{ __('menu.metode_bayar') }}</th>
                <th class="text-right">{{ __('menu.total') }}</th>
                <th class="text-right">{{ __('menu.diskon') }}</th>
                <th class="text-right">{{ __('menu.grand_total') }}</th>
                <th class="text-center">{{ __('menu.status') }}</th>

            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->pelanggan->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($t->metode_bayar) }}</td>
                <td class="text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($t->diskon, 0, ',', '.') }}</td>
                <td class="text-right"><strong>Rp {{ number_format($t->grand_total, 0, ',', '.') }}</strong></td>
                <td class="text-center">
                    <span class="badge badge-{{ $t->status == 'selesai' ? 'selesai' : ($t->status == 'pending' ? 'pending' : 'batal') }}">
                        {{ ucfirst($t->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 30px; color: #999;">
                    {{ __('menu.no_transaksi') }}
                </td>
            </tr>

            @endforelse
        </tbody>
        @if($transaksis->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('diskon'), 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('grand_total'), 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer-print">
        <span>Dicetak oleh: {{ auth()->user()->name }}</span>
        <span>Tanggal cetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</span>
    </div>

</div>

</body>
</html>