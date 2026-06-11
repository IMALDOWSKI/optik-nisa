<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Barcode - {{ $produk->nama_produk }}</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            padding: 20px;
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

        .toolbar h5 {
            margin: 0;
            flex: 1;
            color: #1a3a5c;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary { background: #1a3a5c; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-secondary { background: #6c757d; color: white; }

        .label-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .label-card {
            background: white;
            border: 1px dashed #ccc;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            width: 200px;
        }

        .label-card .toko-nama {
            font-size: 11px;
            font-weight: bold;
            color: #1a3a5c;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .label-card .produk-nama {
            font-size: 10px;
            color: #333;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .label-card svg {
            max-width: 100%;
        }

        .label-card .kode {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
            font-family: monospace;
        }

        .label-card .harga {
            font-size: 12px;
            font-weight: bold;
            color: #1a3a5c;
            margin-top: 4px;
        }

        .jumlah-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
        }

        @media print {
            body { background: white; padding: 0; }
            .toolbar { display: none; }
            .label-preview { gap: 5px; }
            .label-card {
                border: 1px dashed #ccc;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <h5>🏷️ Label Barcode — {{ $produk->nama_produk }}</h5>
    <div class="jumlah-control">
        <label style="font-size:14px; font-weight:bold;">Jumlah Label:</label>
        <input type="number" id="jumlahLabel" value="1" min="1" max="50"
               style="width:70px; padding:6px; border:1px solid #ddd; border-radius:4px; font-size:14px;">
        <button class="btn btn-primary" onclick="generateLabels()">
            🔄 Generate
        </button>
    </div>
    <button class="btn btn-success" onclick="window.print()">
        🖨️ Print
    </button>
    <a href="{{ route('produk.show', $produk) }}" class="btn btn-secondary">
        ← Kembali
    </a>
</div>

<div class="label-preview" id="labelContainer">
    {{-- Label akan digenerate oleh JavaScript --}}
</div>

<script>
    const produk = {
        kode      : '{{ $produk->barcode ?? $produk->kode_produk }}',
        nama      : '{{ addslashes($produk->nama_produk) }}',
        harga     : '{{ number_format($produk->harga, 0, ',', '.') }}',
        kategori  : '{{ ucfirst($produk->kategori) }}',
    };

    function generateLabels() {
        const jumlah    = parseInt(document.getElementById('jumlahLabel').value) || 1;
        const container = document.getElementById('labelContainer');
        container.innerHTML = '';

        for (let i = 0; i < jumlah; i++) {
            const div = document.createElement('div');
            div.className = 'label-card';
            div.innerHTML = `
                <div class="toko-nama">OPTIK NISA</div>
                <div class="produk-nama">${produk.nama}</div>
                <svg class="barcode-${i}"></svg>
                <div class="kode">${produk.kode}</div>
                <div class="harga">Rp ${produk.harga}</div>
            `;
            container.appendChild(div);

            // Generate barcode
            JsBarcode(`.barcode-${i}`, produk.kode, {
                format      : 'CODE128',
                width       : 1.5,
                height      : 40,
                displayValue: false,
                margin      : 0,
            });
        }
    }

    // Generate 1 label saat halaman load
    generateLabels();
</script>

</body>
</html>