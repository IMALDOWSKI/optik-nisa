<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Barcode Massal - Optik Nisa</title>
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
            flex-wrap: wrap;
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

        .btn-primary   { background: #1a3a5c; color: white; }
        .btn-success   { background: #28a745; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-danger    { background: #dc3545; color: white; }

        .produk-list {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .produk-list h6 {
            color: #1a3a5c;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .produk-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .produk-item:last-child { border-bottom: none; }

        .produk-item label {
            flex: 1;
            cursor: pointer;
            font-size: 14px;
        }

        .produk-item input[type="number"] {
            width: 60px;
            padding: 4px 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }

        .label-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .label-card {
            background: white;
            border: 1px dashed #ccc;
            padding: 8px;
            text-align: center;
            width: 180px;
        }

        .label-card .toko-nama {
            font-size: 10px;
            font-weight: bold;
            color: #1a3a5c;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .label-card .produk-nama {
            font-size: 9px;
            color: #333;
            margin: 2px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .label-card .kode {
            font-size: 8px;
            color: #666;
            font-family: monospace;
        }

        .label-card .harga {
            font-size: 11px;
            font-weight: bold;
            color: #1a3a5c;
            margin-top: 3px;
        }

        @media print {
            body { background: white; padding: 5px; }
            .toolbar, .produk-list { display: none; }
            .label-preview { gap: 3px; }
            .label-card { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <h5>🏷️ Cetak Barcode Massal</h5>
    <button class="btn btn-primary" onclick="pilihSemua()">☑️ Pilih Semua</button>
    <button class="btn btn-danger" onclick="hapusPilihan()">✖️ Hapus Pilihan</button>
    <button class="btn btn-primary" onclick="generateLabels()">🔄 Generate Preview</button>
    <button class="btn btn-success" onclick="window.print()">🖨️ Print Semua</button>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

{{-- Pilih Produk --}}
<div class="produk-list">
    <h6>📦 Pilih Produk yang Ingin Dicetak Labelnya:</h6>
    @foreach($produks as $p)
    <div class="produk-item">
<input type="checkbox" id="produk_{{ $p->id }}"
       class="produk-check"
       data-kode="{{ $p->barcode ?: ($p->kode_produk ?: 'PRD' . str_pad($p->id, 5, '0', STR_PAD_LEFT)) }}"
       data-nama="{{ $p->nama_produk }}"
       data-harga="{{ number_format($p->harga, 0, ',', '.') }}"
       value="{{ $p->id }}">
        <label for="produk_{{ $p->id }}">
            <strong>{{ $p->nama_produk }}</strong>
            <span style="color:#666; font-size:12px;">
                — {{ $p->kode_produk }}
                — Rp {{ number_format($p->harga, 0, ',', '.') }}
            </span>
        </label>
        <input type="number" class="jumlah-{{ $p->id }}"
               value="1" min="1" max="50"
               style="width:60px;" placeholder="Jml">
    </div>
    @endforeach
</div>

{{-- Preview Label --}}
<div id="labelContainer" class="label-preview"></div>

<script>
    let labelCount = 0;

    function pilihSemua() {
        document.querySelectorAll('.produk-check').forEach(cb => cb.checked = true);
    }

    function hapusPilihan() {
        document.querySelectorAll('.produk-check').forEach(cb => cb.checked = false);
        document.getElementById('labelContainer').innerHTML = '';
    }

    function generateLabels() {
        const container = document.getElementById('labelContainer');
        container.innerHTML = '';
        labelCount = 0;

        const checked = document.querySelectorAll('.produk-check:checked');

        if (checked.length === 0) {
            alert('Pilih minimal 1 produk terlebih dahulu!');
            return;
        }

        checked.forEach(function(cb) {
            const id     = cb.value;
            const kode   = cb.dataset.kode;
            const nama   = cb.dataset.nama;
            const harga  = cb.dataset.harga;
            const jumlah = parseInt(document.querySelector('.jumlah-' + id).value) || 1;

for (let i = 0; i < jumlah; i++) {
    const idx = labelCount++;
    const div = document.createElement('div');
    div.className = 'label-card';

    // Pastikan kode tidak kosong
    const kodeBarcode = kode && kode.trim() !== '' ? kode : 'NOCODE';

    div.innerHTML = `
        <div class="toko-nama">OPTIK NISA</div>
        <div class="produk-nama">${nama}</div>
        <svg class="barcode-gen-${idx}"></svg>
        <div class="kode">${kodeBarcode}</div>
        <div class="harga">Rp ${harga}</div>
    `;
    container.appendChild(div);

    try {
        JsBarcode(`.barcode-gen-${idx}`, kodeBarcode, {
            format      : 'CODE128',
            width       : 1.5,
            height      : 35,
            displayValue: false,
            margin      : 0,
        });
    } catch (e) {
        console.warn('Gagal generate barcode untuk:', nama, e);
        document.querySelector(`.barcode-gen-${idx}`).outerHTML =
            '<div style="font-size:10px;color:red;padding:10px 0;">Barcode tidak valid</div>';
    }
}
        });
    }
</script>

</body>
</html>