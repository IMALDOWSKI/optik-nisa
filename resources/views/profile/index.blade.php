@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile Saya</h1>
</div>

<div class="row">

    {{-- Info Profile --}}
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user mr-2"></i>Informasi Profile
                </h6>
            </div>
            <div class="card-body">

                {{-- Avatar --}}
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3"
                         style="width:80px; height:80px; background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
                                border-radius: 50%; display:flex; align-items:center;
                                justify-content:center; font-size:2rem; color:white; font-weight:bold;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="font-weight-bold">{{ $user->name }}</h5>
                    <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : 'info' }} px-3 py-1">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Role</label>
                        <input type="text" class="form-control bg-light"
                               value="{{ ucfirst($user->role) }}" readonly>
                        <small class="text-muted">Role tidak dapat diubah sendiri</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Ganti Password --}}
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-lock mr-2"></i>Ganti Password
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.ganti-password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="font-weight-bold">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="password_lama" id="passwordLama"
                                   class="form-control @error('password_lama') is-invalid @enderror"
                                   placeholder="Masukkan password lama">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="passwordLama">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password_lama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="passwordBaru"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="passwordBaru">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="passwordKonfirmasi"
                                   class="form-control"
                                   placeholder="Ulangi password baru">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="passwordKonfirmasi">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Indikator Kekuatan Password --}}
                    <div class="form-group">
                        <label class="font-weight-bold small">Kekuatan Password</label>
                        <div class="progress" style="height: 6px;">
                            <div id="passwordStrength" class="progress-bar" style="width:0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted"></small>
                    </div>

                    <button type="submit" class="btn btn-warning btn-block">
                        <i class="fas fa-key mr-2"></i>Ganti Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Akun --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Info Akun
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Bergabung Sejak</td>
                        <td class="font-weight-bold">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Terakhir Update</td>
                        <td class="font-weight-bold">
                            {{ $user->updated_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge badge-success">Aktif</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Toggle show/hide password
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const target = document.getElementById(this.dataset.target);
            const icon   = this.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                target.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // Indikator kekuatan password
    document.getElementById('passwordBaru').addEventListener('input', function() {
        const val      = this.value;
        const bar      = document.getElementById('passwordStrength');
        const text     = document.getElementById('passwordStrengthText');
        let strength   = 0;
        let label      = '';
        let color      = '';

        if (val.length >= 6)  strength++;
        if (val.length >= 10) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        if (strength <= 1) {
            label = 'Lemah'; color = 'bg-danger'; bar.style.width = '20%';
        } else if (strength <= 2) {
            label = 'Cukup'; color = 'bg-warning'; bar.style.width = '50%';
        } else if (strength <= 3) {
            label = 'Baik'; color = 'bg-info'; bar.style.width = '75%';
        } else {
            label = 'Kuat'; color = 'bg-success'; bar.style.width = '100%';
        }

        bar.className = 'progress-bar ' + color;
        text.innerText = val.length > 0 ? 'Kekuatan: ' + label : '';
    });
</script>
@endpush