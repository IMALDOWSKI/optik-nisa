@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Member</h1>
    <a href="{{ route('member.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@php $label = $member->labelLevel(); @endphp

<div class="row">
    <div class="col-md-5">

        {{-- Kartu Member --}}
        <div class="card shadow mb-4"
             style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
                    color: white; border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div style="font-size: 0.7rem; opacity: 0.7; letter-spacing: 2px;">
                            OPTIK NISA MEMBER CARD
                        </div>
                        <div style="font-size: 1.3rem; font-weight: bold; margin-top: 5px;">
                            {{ $member->pelanggan->nama }}
                        </div>
                    </div>
                    <span class="badge badge-{{ $label['color'] }} px-3 py-2"
                          style="font-size: 0.9rem;">
                        {{ $label['label'] }}
                    </span>
                </div>

                <div style="font-size: 1rem; letter-spacing: 3px; opacity: 0.9; margin: 20px 0;">
                    {{ $member->no_member }}
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <div style="font-size: 0.65rem; opacity: 0.7;">POIN AKTIF</div>
                        <div style="font-size: 1.5rem; font-weight: bold;">
                            {{ number_format($member->poinAktif()) }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div style="font-size: 0.65rem; opacity: 0.7;">NILAI POIN</div>
                        <div style="font-size: 1.1rem; font-weight: bold;">
                            Rp {{ number_format(\App\Models\Member::nilaiPoin($member->poinAktif()), 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div style="font-size: 0.7rem; opacity: 0.6; margin-top: 15px;">
                    Bergabung sejak {{ \Carbon\Carbon::parse($member->tanggal_bergabung)->format('d/m/Y') }}
                </div>
            </div>
        </div>

        {{-- Statistik Poin --}}
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Total Poin Didapat</td>
                        <td class="font-weight-bold text-success">
                            {{ number_format($member->total_poin) }} poin
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Poin Digunakan</td>
                        <td class="font-weight-bold text-danger">
                            {{ number_format($member->total_poin_digunakan) }} poin
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Poin Aktif</td>
                        <td class="font-weight-bold text-primary">
                            {{ number_format($member->poinAktif()) }} poin
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nilai Bisa Ditukar</td>
                        <td class="font-weight-bold">
                            Rp {{ number_format(\App\Models\Member::nilaiPoin($member->poinAktif()), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Tukar Poin --}}
        @if($member->poinAktif() > 0 && $member->status == 'aktif')
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-exchange-alt mr-2"></i>Tukar Poin
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('member.tukar-poin', $member) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Jumlah Poin Ditukar</label>
                        <input type="number" name="poin_ditukar"
                               class="form-control @error('poin_ditukar') is-invalid @enderror"
                               min="1" max="{{ $member->poinAktif() }}"
                               placeholder="Maks: {{ number_format($member->poinAktif()) }} poin"
                               id="inputPoinTukar">
                        @error('poin_ditukar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="alert alert-info py-2 d-none" id="infoNilaiTukar">
                        Nilai diskon: <strong id="nilaiTukar">Rp 0</strong>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block"
                            onclick="return confirm('Yakin tukar poin ini?')">
                        <i class="fas fa-exchange-alt mr-2"></i>Tukar Poin
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>

    <div class="col-md-7">
        {{-- Riwayat Poin --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history mr-2"></i>Riwayat Poin
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($member->poinRiwayats->sortByDesc('created_at') as $r)
                        <tr>
                            <td>{{ $r->created_at->format('d/m/Y') }}</td>
                            <td>{{ $r->keterangan }}</td>
                            <td>
                                <span class="badge badge-{{ $r->tipe == 'masuk' ? 'success' : 'danger' }}">
                                    {{ $r->tipe == 'masuk' ? '+' : '-' }}{{ $r->poin }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                Belum ada riwayat poin
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('inputPoinTukar')?.addEventListener('input', function() {
        const poin  = parseInt(this.value) || 0;
        const nilai = poin * 1000;
        const info  = document.getElementById('infoNilaiTukar');
        const text  = document.getElementById('nilaiTukar');

        if (poin > 0) {
            info.classList.remove('d-none');
            text.innerText = 'Rp ' + nilai.toLocaleString('id-ID');
        } else {
            info.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection