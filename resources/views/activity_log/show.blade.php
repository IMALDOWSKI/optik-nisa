@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Activity Log</h1>
    <a href="{{ route('activity-log.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-info-circle mr-2"></i>Informasi Activity
        </h6>
        <span class="badge badge-{{ $activityLog->warnaAksi() }} px-3 py-2">
            {{ ucfirst($activityLog->aksi) }}
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted">User</td>
                        <td>
                            <strong>{{ $activityLog->user->name ?? 'System' }}</strong>
                            @if($activityLog->user)
                                <span class="badge badge-{{ $activityLog->user->role == 'admin' ? 'danger' : 'info' }} ml-1">
                                    {{ ucfirst($activityLog->user->role) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Modul</td>
                        <td><span class="badge badge-secondary">{{ $activityLog->modul }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Aksi</td>
                        <td>
                            <span class="badge badge-{{ $activityLog->warnaAksi() }}">
                                {{ ucfirst($activityLog->aksi) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Deskripsi</td>
                        <td>{{ $activityLog->deskripsi }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu</td>
                        <td>{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted">IP Address</td>
                        <td><code>{{ $activityLog->ip_address ?? '-' }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Browser</td>
                        <td>
                            <small class="text-muted">
                                {{ Str::limit($activityLog->user_agent, 50) }}
                            </small>
                        </td>
                    </tr>
                    @if($activityLog->model_type)
                    <tr>
                        <td class="text-muted">Model</td>
                        <td>
                            <code>{{ class_basename($activityLog->model_type) }}</code>
                            #{{ $activityLog->model_id }}
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Data Perubahan --}}
        @if($activityLog->data_lama || $activityLog->data_baru)
        <hr>
        <div class="row">
            @if($activityLog->data_lama)
            <div class="col-md-6">
                <h6 class="font-weight-bold text-danger">Data Sebelum:</h6>
                <pre class="bg-light p-3 rounded" style="font-size:12px">{{ json_encode($activityLog->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            @endif
            @if($activityLog->data_baru)
            <div class="col-md-6">
                <h6 class="font-weight-bold text-success">Data Sesudah:</h6>
                <pre class="bg-light p-3 rounded" style="font-size:12px">{{ json_encode($activityLog->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection