<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            color: #000;
            width: 100%;
        }
        .center { text-align: center; }
        .right  { text-align: right; }
        .bold   { font-weight: bold; }
        .header {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 1px dashed #000;
            margin-bottom: 8px;
        }
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .header p { font-size: 10px; }
        .info-transaksi {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #000;
        }
        .info-transaksi table { width: 100%; }
        .info-transaksi td {
            font-size: 10px;
            padding: 1px 0;
        }
        .info-transaksi td:last-child { text-align: right; }
        .produk-header {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
            margin: 4px 0;
            font-size: 10px;
            font-weight: bold;
        }
        .produk-item { margin-bottom: 6px; }
        .produk-item .nama {
            font-size: 11px;
            font-weight: bold;
        }
        .produk-item .detail {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }
        .total-section {
            border-top: 1px dashed #000;
            margin-top: 8px;
            padding-top: 8px;
        }
        .total-section table { width: 100%; }
        .total-section td {
            padding: 2px 0;
            font-size: 11px;
        }
        .total-section td:last-child { text-align: right; }
        .grand-total {
            font-size: 13px;
            font-weight: bold;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
        }
        .footer {
            margin-top: 12px;
            text-align: center;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 8px;
        }
        .footer .terima-kasih {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h2>OPTIK NISA</h2>
        <p>Sistem Manajemen Optik</p>
        <p>Telp: (0651) xxx-xxxx</p>
    </div>

    {{-- Info Transaksi --}}
    <div class="info-transaksi">
        <table>
            <tr>
                <td>No. Struk</td>
                <td>: <strong>{{ $transaksi->kode_transaksi }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: {{ $transaksi->pelanggan->nama }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>: {{ auth()->user()->name }}</td>
            </tr>
        </table>
    </div>

    {{-- Daftar Produk --}}
    <div class="produk-header">
        <table style="width:100%">
            <tr>
                <td>Produk</td>
                <td style="text-align:right">Subtotal</td>
            </tr>
        </table>
    </div>

    @foreach($transaksi->details as $d)
    <div class="produk-item">
        <div class="nama">{{ $d->produk->nama_produk }}</div>
        <div class="detail">
            <span>{{ $d->jumlah }} x Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</span>
            <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
        </div>
    </div>
    @endforeach

    {{-- Total --}}
<div class="total-section">
    <table>
        <tr>
            <td>Subtotal</td>
            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        @if($transaksi->diskon > 0)
        <tr>
            <td>Diskon</td>
            <td>- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr class="grand-total">
            <td><strong>TOTAL</strong></td>
            <td><strong>Rp {{ number_format($transaksi->grand_total > 0 ? $transaksi->grand_total : $transaksi->total_harga, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Metode Bayar</td>
            <td>{{ ucfirst($transaksi->metode_bayar) }}</td>
        </tr>
        @if($transaksi->metode_bayar == 'tunai')
        <tr>
            <td>Bayar</td>
            <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>
</div>

    {{-- Catatan --}}
    @if($transaksi->catatan)
    <div style="margin-top: 8px; font-size: 10px;">
        <strong>Catatan:</strong> {{ $transaksi->catatan }}
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <div class="terima-kasih">Terima Kasih!</div>
        <p>Semoga penglihatan Anda semakin baik</p>
        <p>Simpan struk ini sebagai bukti pembelian</p>
        <p style="margin-top: 6px; font-size: 9px;">
            Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </p>
    </div>

</body>
</html>