@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-id-card mr-2"></i>Kartu Member
    </h1>
    <a href="{{ route('member.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus"></i> Daftarkan Member
    </a>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Member Aktif
                </div>
                <div class="h5 font-weight-bold">{{ $totalMember }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-secondary shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                    🥈 Silver
                </div>
                <div class="h5 font-weight-bold">{{ $totalSilver }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    🥇 Gold
                </div>
                <div class="h5 font-weight-bold">{{ $totalGold }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    💎 Platinum
                </div>
                <div class="h5 font-weight-bold">{{ $totalPlatinum }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No. Member</th>
                        <th>Pelanggan</th>
                        <th>Level</th>
                        <th>Total Poin</th>
                        <th>Poin Aktif</th>
                        <th>Nilai Poin</th>
                        <th>Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                    @php $label = $m->labelLevel(); @endphp
                    <tr>
                        <td><code>{{ $m->no_member }}</code></td>
                        <td><strong>{{ $m->pelanggan->nama }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $label['color'] }}">
                                {{ $label['label'] }}
                            </span>
                        </td>
                        <td>{{ number_format($m->total_poin) }} poin</td>
                        <td>
                            <span class="badge badge-success">
                                {{ number_format($m->poinAktif()) }} poin
                            </span>
                        </td>
                        <td>
                            Rp {{ number_format(Member::nilaiPoin($m->poinAktif()), 0, ',', '.') }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($m->tanggal_bergabung)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $m->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($m->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('member.show', $m) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-id-card fa-2x mb-2 d-block"></i>
                            Belum ada member
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $members->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection