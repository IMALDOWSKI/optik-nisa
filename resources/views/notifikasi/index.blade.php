@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-bell mr-2"></i>Notifikasi
        @if($belumDibaca > 0)
            <span class="badge badge-danger">{{ $belumDibaca }}</span>
        @endif
    </h1>
    <div>
        <form action="{{ route('notifikasi.baca-semua') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-info btn-sm mr-2">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
        <form action="{{ route('notifikasi.hapus-semua') }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus semua notifikasi yang sudah dibaca?')">
                <i class="fas fa-trash"></i> Hapus Sudah Dibaca
            </button>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        @forelse($notifikasis as $n)
        <div class="d-flex align-items-start p-3 border-bottom
                    {{ !$n->sudah_dibaca ? 'bg-light' : '' }}"
             id="notif-{{ $n->id }}">

            {{-- Icon --}}
            <div class="mr-3 mt-1">
                @if($n->tipe == 'stok')
                    <div class="rounded-circle p-2 bg-warning text-white"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-box"></i>
                    </div>
                @elseif($n->tipe == 'pelanggan')
                    <div class="rounded-circle p-2 bg-info text-white"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-user"></i>
                    </div>
                @elseif($n->tipe == 'transaksi')
                    <div class="rounded-circle p-2 bg-success text-white"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                @else
                    <div class="rounded-circle p-2 bg-primary text-white"
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-info"></i>
                    </div>
                @endif
            </div>

            {{-- Konten --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                    <h6 class="font-weight-bold mb-1 {{ !$n->sudah_dibaca ? 'text-primary' : 'text-muted' }}">
                        {{ $n->judul }}
                        @if(!$n->sudah_dibaca)
                            <span class="badge badge-primary ml-1" style="font-size:9px;">BARU</span>
                        @endif
                    </h6>
                    <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-2 text-muted small">{{ $n->pesan }}</p>
                <div>
                    @if($n->url)
                        <a href="{{ $n->url }}" class="btn btn-sm btn-outline-primary mr-1">
                            <i class="fas fa-external-link-alt"></i> Lihat
                        </a>
                    @endif
                    @if(!$n->sudah_dibaca)
                        <button class="btn btn-sm btn-outline-success mr-1 btn-baca"
                                data-id="{{ $n->id }}">
                            <i class="fas fa-check"></i> Tandai Dibaca
                        </button>
                    @endif
                    <form action="{{ route('notifikasi.hapus', $n) }}"
                          method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Hapus notifikasi ini?')">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @empty
        <div class="text-center text-muted py-5">
            <i class="fas fa-bell-slash fa-3x mb-3 d-block"></i>
            <h5>Tidak ada notifikasi</h5>
            <p>Semua berjalan dengan baik!</p>
        </div>
        @endforelse
    </div>
</div>

{{ $notifikasis->links('pagination::bootstrap-4') }}

@push('scripts')
<script>
document.querySelectorAll('.btn-baca').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const id  = this.dataset.id;
        const row = document.getElementById('notif-' + id);

        fetch('/notifikasi/' + id + '/baca', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                row.classList.remove('bg-light');
                this.remove();
            }
        });
    });
});
</script>
@endpush
@endsection