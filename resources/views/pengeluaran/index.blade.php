@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-money-bill-wave mr-2"></i>Pengeluaran Toko
    </h1>
    <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Tambah Pengeluaran
    </a>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('pengeluaran.index') }}" class="form-inline">
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">Bulan:</label>
                <select name="bulan" class="form-control">
                    @foreach($daftarBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mr-3">
                <label class="mr-2 font-weight-bold">Tahun:</label>
                <select name="tahun" class="form-control">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter
            </button>
        </form>
    </div>
</div>

<div class="row">
    {{-- Tabel Pengeluaran --}}
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Daftar Pengeluaran — {{ $daftarBulan[$bulan] }} {{ $tahun }}
                </h6>
                <span class="font-weight-bold text-danger">
                    Total: Rp {{ number_format($totalBulanIni, 0, ',', '.') }}
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Dicatat Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluarans as $p)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $p->judul }}</td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ \App\Models\Pengeluaran::daftarKategori()[$p->kategori] ?? $p->kategori }}
                                    </span>
                                </td>
                                <td class="text-danger font-weight-bold">
                                    Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                </td>
                                <td>{{ $p->user->name }}</td>
                                <td>
                                    <form action="{{ route('pengeluaran.destroy', $p) }}"
                                          method="POST" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus pengeluaran ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada pengeluaran bulan ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $pengeluarans->links('pagination::bootstrap-4') }}
    </div>

    {{-- Per Kategori --}}
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie mr-2"></i>Per Kategori
                </h6>
            </div>
            <div class="card-body p-0">
                @forelse($perKategori as $k)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <span>
                        {{ \App\Models\Pengeluaran::daftarKategori()[$k->kategori] ?? $k->kategori }}
                    </span>
                    <span class="font-weight-bold text-danger">
                        Rp {{ number_format($k->total, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <div class="text-center text-muted py-3">
                    Belum ada data
                </div>
                @endforelse
                @if($perKategori->count() > 0)
                <div class="d-flex justify-content-between align-items-center p-3 bg-light">
                    <strong>Total</strong>
                    <strong class="text-danger">
                        Rp {{ number_format($totalBulanIni, 0, ',', '.') }}
                    </strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection