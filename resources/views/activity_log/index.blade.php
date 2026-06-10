@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-history mr-2"></i>Activity Log
    </h1>
    <form action="{{ route('activity-log.hapus-lama') }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Hapus semua log lebih dari 30 hari?')">
            <i class="fas fa-trash mr-1"></i>Hapus Log Lama
        </button>
    </form>
</div>

{{-- Filter --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('activity-log.index') }}" class="row">
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="font-weight-bold small">User</label>
                    <select name="user_id" class="form-control form-control-sm">
                        <option value="">Semua User</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}"
                                {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label class="font-weight-bold small">Modul</label>
                    <select name="modul" class="form-control form-control-sm">
                        <option value="">Semua Modul</option>
                        @foreach($moduls as $m)
                            <option value="{{ $m }}"
                                {{ request('modul') == $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label class="font-weight-bold small">Aksi</label>
                    <select name="aksi" class="form-control form-control-sm">
                        <option value="">Semua Aksi</option>
                        @foreach(['login','logout','create','update','delete','export','print'] as $a)
                            <option value="{{ $a }}"
                                {{ request('aksi') == $a ? 'selected' : '' }}>
                                {{ ucfirst($a) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="font-weight-bold small">Tanggal</label>
                    <input type="date" name="tanggal"
                           class="form-control form-control-sm"
                           value="{{ request('tanggal') }}">
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    <i class="fas fa-search mr-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Modul</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="small">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                            <br>
                            <span class="text-muted">{{ $log->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            @if($log->user)
                                <strong>{{ $log->user->name }}</strong>
                                <br>
                                <span class="badge badge-{{ $log->user->role == 'admin' ? 'danger' : 'info' }} badge-sm">
                                    {{ ucfirst($log->user->role) }}
                                </span>
                            @else
                                <span class="text-muted">System</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-secondary">{{ $log->modul }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $log->warnaAksi() }}">
                                {{ ucfirst($log->aksi) }}
                            </span>
                        </td>
                        <td>{{ $log->deskripsi }}</td>
                        <td class="small text-muted">{{ $log->ip_address }}</td>
                        <td>
                            <a href="{{ route('activity-log.show', $log) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-history fa-2x mb-2 d-block"></i>
                            Belum ada activity log
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{ $logs->links('pagination::bootstrap-4') }}
@endsection