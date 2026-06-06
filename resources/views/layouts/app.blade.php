<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Optik Nisa</title>

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* ===== WARNA UTAMA NAVY BLUE ===== */
        :root {
            --primary: #1a3a5c;
            --primary-dark: #0f2340;
            --primary-light: #2d5f8a;
            --accent: #00b4d8;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #1a3a5c 0%, #0f2340 100%) !important;
        }

        .sidebar .nav-item .nav-link {
            color: rgba(255,255,255,0.7) !important;
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s;
        }

        .sidebar .nav-item .nav-link:hover,
        .sidebar .nav-item.active .nav-link {
            color: #ffffff !important;
            background: rgba(255,255,255,0.15) !important;
        }

        .sidebar .nav-item.active .nav-link {
            background: rgba(0,180,216,0.3) !important;
            border-left: 3px solid #00b4d8;
        }

        .sidebar-brand {
            background: rgba(0,0,0,0.2) !important;
            padding: 1.5rem 1rem !important;
        }

        .sidebar-brand-text {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            letter-spacing: 1px;
        }

        .sidebar-heading {
            color: rgba(255,255,255,0.4) !important;
            font-size: 0.65rem !important;
            letter-spacing: 2px;
            padding: 0.5rem 1rem;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,0.1) !important;
        }

        /* Topbar */
        .topbar {
            background: #ffffff !important;
            border-bottom: 2px solid #e8f4fd !important;
            box-shadow: 0 2px 10px rgba(26,58,92,0.08) !important;
        }

        /* Tombol Primary */
        .btn-primary {
            background: linear-gradient(135deg, #1a3a5c, #2d5f8a) !important;
            border-color: #1a3a5c !important;
            border-radius: 8px !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0f2340, #1a3a5c) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26,58,92,0.3) !important;
        }

        /* Card */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(26,58,92,0.08) !important;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26,58,92,0.12) !important;
        }

        .card-header {
            background: #ffffff !important;
            border-bottom: 2px solid #e8f4fd !important;
            border-radius: 12px 12px 0 0 !important;
        }

        /* Border Left Cards */
        .border-left-primary { border-left: 4px solid #1a3a5c !important; }
        .border-left-success { border-left: 4px solid #00b4d8 !important; }
        .border-left-info    { border-left: 4px solid #2d5f8a !important; }
        .border-left-warning { border-left: 4px solid #f6a623 !important; }

        /* Text Colors */
        .text-primary { color: #1a3a5c !important; }

        /* Badge */
        .badge-primary { background: #1a3a5c !important; }

        /* Table */
        .table thead.thead-dark th {
            background: linear-gradient(135deg, #1a3a5c, #2d5f8a) !important;
            border-color: #2d5f8a !important;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr:hover {
            background: #f0f7ff !important;
        }

        /* Page Content Background */
        #content-wrapper {
            background: #f0f4f8 !important;
        }

        /* Alert */
        .alert {
            border-radius: 10px !important;
            border: none !important;
        }

        /* Form Controls */
        .form-control {
            border-radius: 8px !important;
            border-color: #d0e4f7 !important;
        }

        .form-control:focus {
            border-color: #1a3a5c !important;
            box-shadow: 0 0 0 0.2rem rgba(26,58,92,0.15) !important;
        }

        /* Pagination */
        .page-link {
            color: #1a3a5c !important;
            border-radius: 6px !important;
            margin: 0 2px;
        }

        .page-item.active .page-link {
            background: #1a3a5c !important;
            border-color: #1a3a5c !important;
            color: white !important;
        }

        /* Footer */
        .sticky-footer {
            background: #ffffff !important;
            border-top: 1px solid #e8f4fd !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f0f4f8; }
        ::-webkit-scrollbar-thumb {
            background: #1a3a5c;
            border-radius: 3px;
        }
    </style>
</head>

<body id="page-top">
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center"
           href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-glasses"></i>
            </div>
            <div class="sidebar-brand-text mx-3">OPTIK NISA</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Data Master</div>

        <li class="nav-item {{ Request::is('pelanggan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pelanggan.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('produk*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produk.index') }}">
                <i class="fas fa-fw fa-glasses"></i>
                <span>Produk</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('transaksi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('resep*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('resep.index') }}">
                <i class="fas fa-fw fa-eye"></i>
                <span>Resep Mata</span>
            </a>
        </li>

        @if(auth()->user()->role == 'admin')
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Laporan</div>

        <li class="nav-item {{ Request::is('laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laporan.index') }}">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Laporan Transaksi</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Pengaturan</div>

        <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Manajemen User</span>
            </a>
        </li>
        @endif

        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">

                    <!-- Notifikasi Stok -->
                    @php $stokKritis = \App\Models\Produk::where('stok', '<=', 5)->count(); @endphp
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown"
                           role="button" data-toggle="dropdown">
                            <i class="fas fa-bell fa-fw"></i>
                            @if($stokKritis > 0)
                                <span class="badge badge-danger badge-counter">{{ $stokKritis }}</span>
                            @endif
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in">
                            <h6 class="dropdown-header"
                                style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);">
                                Peringatan Stok
                            </h6>
                            @forelse(\App\Models\Produk::where('stok','<=',5)->get() as $s)
                                <a class="dropdown-item d-flex align-items-center"
                                   href="{{ route('produk.index') }}">
                                    <div class="mr-3">
                                        <span class="badge badge-{{ $s->stok == 0 ? 'danger' : 'warning' }}">
                                            {{ $s->stok }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Stok Menipis</div>
                                        <span class="font-weight-bold">{{ $s->nama_produk }}</span>
                                    </div>
                                </a>
                            @empty
                                <div class="dropdown-item text-center text-muted py-3">
                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                    Semua stok aman!
                                </div>
                            @endforelse
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- User Info -->
<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
       role="button" data-toggle="dropdown">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
            {{ auth()->user()->name }}
            <span class="badge badge-{{ auth()->user()->role == 'admin' ? 'danger' : 'info' }} ml-1">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </span>
        <div class="avatar-circle">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
        <div class="dropdown-header text-center">
            <small class="text-muted">{{ auth()->user()->email }}</small>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('profile.index') }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
            Profile Saya
        </a>
        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                Logout
            </button>
        </form>
    </div>
</li>
                </ul>
            </nav>
            <!-- End Topbar -->

            <!-- Page Content -->
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span class="text-muted">
                        Optik Nisa &copy; {{ date('Y') }} —
                        Sistem Manajemen Optik
                    </span>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }
</style>

@stack('scripts')
</body>
</html>