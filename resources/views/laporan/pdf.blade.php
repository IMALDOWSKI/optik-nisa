<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
    <div>
        <a href="{{ route('laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="btn btn-danger btn-sm shadow-sm mr-2">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.csv', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-file-excel"></i> Export Excel (CSV)
        </a>
    </div>
</div>