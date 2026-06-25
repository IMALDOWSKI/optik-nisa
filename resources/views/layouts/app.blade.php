<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Optik Nisa</title>

{{-- PWA Manifest --}}
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#1a3a5c">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Optik Nisa">
<link rel="apple-touch-icon" href="{{ asset('icons/launchericon-192x192.png') }}">
<link rel="icon" type="image/png" href="{{ asset('icons/launchericon-192x192.png') }}">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* ===== DARK MODE ===== */
        body.dark-mode {
            background-color: #1a1d29 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode #content-wrapper {
            background: #1a1d29 !important;
        }

        body.dark-mode .card {
            background-color: #242837 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-header {
            background-color: #242837 !important;
            border-bottom: 2px solid #343a4d !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table {
            color: #e0e0e0 !important;
        }

        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #343a4d !important;
        }

        body.dark-mode .table tbody tr:hover {
            background: #2d3245 !important;
        }

        body.dark-mode .thead-light th,
        body.dark-mode .thead-dark th {
            background-color: #2d3245 !important;
            color: #e0e0e0 !important;
            border-color: #343a4d !important;
        }

        body.dark-mode .topbar {
            background-color: #242837 !important;
            border-bottom: 2px solid #343a4d !important;
        }

        body.dark-mode .navbar-light .navbar-nav .nav-link {
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control {
            background-color: #2d3245 !important;
            border-color: #343a4d !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control:focus {
            background-color: #2d3245 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control::placeholder {
            color: #8a8fa3 !important;
        }

        body.dark-mode .text-gray-800,
        body.dark-mode .text-gray-600,
        body.dark-mode .text-gray-500,
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #e0e0e0 !important;
        }

        body.dark-mode .dropdown-menu {
            background-color: #242837 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .dropdown-item {
            color: #e0e0e0 !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #2d3245 !important;
            color: #ffffff !important;
        }

        body.dark-mode .dropdown-divider {
            border-color: #343a4d !important;
        }

        body.dark-mode .sticky-footer {
            background-color: #242837 !important;
            border-top: 1px solid #343a4d !important;
        }

        body.dark-mode .sticky-footer .text-muted {
            color: #8a8fa3 !important;
        }

        body.dark-mode .alert-success {
            background-color: #1f4030 !important;
            color: #7fffa0 !important;
        }

        body.dark-mode .alert-danger {
            background-color: #4a1f24 !important;
            color: #ff8a94 !important;
        }

        body.dark-mode .alert-info {
            background-color: #1f3a4a !important;
            color: #7fd4ff !important;
        }

        body.dark-mode .alert-warning {
            background-color: #4a3c1f !important;
            color: #ffd97f !important;
        }

        body.dark-mode code {
            background-color: #2d3245 !important;
            padding: 2px 6px;
            border-radius: 4px;
        }

        body.dark-mode hr {
            border-color: #343a4d !important;
        }

        body.dark-mode .border-borderless td,
        body.dark-mode .table-borderless td {
            border: none !important;
        }

        body.dark-mode .modal-content {
            background-color: #242837 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .close {
            color: #e0e0e0 !important;
        }

        /* Toggle Switch Dark Mode */
        .dark-mode-toggle {
            cursor: pointer;
            font-size: 1.1rem;
            color: #6c757d;
            transition: color 0.2s;
        }

        body.dark-mode .dark-mode-toggle {
            color: #f6c343 !important;
        }

        /* ===== RESPONSIVE MOBILE ===== */

        /* Tablet & HP (max 768px) */
        @media (max-width: 768px) {

            /* Judul halaman lebih kecil */
            h1.h3 {
                font-size: 1.3rem !important;
            }

            /* Card padding lebih kecil */
            .card-body {
                padding: 1rem !important;
            }

            /* Header halaman (judul + tombol) jadi vertikal */
            .d-sm-flex.align-items-center.justify-content-between {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px;
            }

            .d-sm-flex.align-items-center.justify-content-between > div,
            .d-sm-flex.align-items-center.justify-content-between a.btn {
                width: 100%;
            }

            .d-sm-flex.align-items-center.justify-content-between a.btn {
                text-align: center;
            }

            /* Statistik card - jangan terlalu padat */
            .border-left-primary, .border-left-success,
            .border-left-info, .border-left-warning,
            .border-left-danger, .border-left-secondary {
                margin-bottom: 0.75rem;
            }

            /* Tabel - font lebih kecil supaya tidak terlalu lebar */
            .table {
                font-size: 0.8rem;
            }

            .table th, .table td {
                padding: 0.5rem !important;
                white-space: nowrap;
            }

            /* Tombol aksi di tabel - susun rapi */
            .table .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.7rem;
                margin-bottom: 2px;
            }

            /* Form inline (filter) jadi vertikal */
            form.form-inline {
                flex-direction: column !important;
                align-items: stretch !important;
            }

            form.form-inline .form-group {
                margin-bottom: 0.75rem !important;
                width: 100%;
            }

            form.form-inline .form-group select,
            form.form-inline .form-group input {
                width: 100% !important;
            }

            form.form-inline .btn {
                width: 100%;
                margin-top: 5px;
            }

            /* Modal full width di HP */
            .modal-dialog {
                margin: 10px;
            }

            /* Chart canvas - batasi tinggi di HP */
            canvas {
                max-height: 280px !important;
            }

            /* Sidebar brand text */
            .sidebar-brand-text {
                font-size: 0.95rem !important;
            }

            /* Topbar - kurangi spacing */
            .topbar-divider {
                margin: 0 0.5rem !important;
            }

            .navbar-nav .nav-item {
                margin: 0 !important;
            }

            /* User dropdown - sembunyikan nama di HP kecil */
            #userDropdown .text-gray-600 {
                display: none !important;
            }

            /* Card kartu member - sesuaikan padding */
            .card-body[style*="padding: 1.5rem"],
            .card-body.p-4 {
                padding: 1rem !important;
            }
        }

        /* HP Kecil (max 576px) */
        @media (max-width: 576px) {

            .container-fluid {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            h1.h3 {
                font-size: 1.15rem !important;
            }

            /* Statistik value - kecilkan */
            .h5.mb-0.font-weight-bold,
            .h5.font-weight-bold {
                font-size: 1rem !important;
            }

            /* Tabel makin kecil */
            .table {
                font-size: 0.72rem;
            }

            /* Sembunyikan kolom kurang penting di tabel (tambahkan class d-none-mobile manual jika perlu) */
            .d-none-mobile {
                display: none !important;
            }

            /* Tombol grup jadi block penuh */
            .btn-group {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                width: 100%;
                margin-bottom: 4px;
                border-radius: 8px !important;
            }

            /* Pagination lebih kecil */
            .pagination {
                font-size: 0.8rem;
            }

            /* Sidebar toggle lebih mudah ditekan */
            #sidebarToggleTop {
                font-size: 1.3rem;
                padding: 0.5rem 0.75rem;
            }
        }

        /* Perbaikan umum: tabel selalu scroll horizontal di semua ukuran kecil */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }

        /* Perbaikan: card shadow lebih ringan di HP biar tidak berat render */
        @media (max-width: 768px) {
            .card {
                box-shadow: 0 1px 6px rgba(26,58,92,0.08) !important;
            }
            .card:hover {
                transform: none !important;
            }
        }
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
@yield('styles')
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
                <span>{{ __('menu.dashboard') }}</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Data Master</div>

        <li class="nav-item {{ Request::is('pengeluaran*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pengeluaran.index') }}">
        <i class="fas fa-fw fa-money-bill-wave"></i>
        <span>Pengeluaran</span>
    </a>
</li>

        <li class="nav-item {{ Request::is('pelanggan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pelanggan.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>{{ __('menu.pelanggan') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('member*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('member.index') }}">
        <i class="fas fa-fw fa-id-card"></i>
        <span>Kartu Member</span>
    </a>
</li>

        <li class="nav-item {{ Request::is('produk*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produk.index') }}">
                <i class="fas fa-fw fa-glasses"></i>
                <span>{{ __('menu.produk') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('restok*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('restok.index') }}">
        <i class="fas fa-fw fa-boxes"></i>
        <span>Restok Produk</span>
    </a>
</li>

<li class="nav-item {{ Request::is('supplier*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('supplier.index') }}">
        <i class="fas fa-fw fa-truck"></i>
        <span>Supplier</span>
    </a>
</li>

        <li class="nav-item {{ Request::is('transaksi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>{{ __('menu.transaksi') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('pesanan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pesanan.index') }}">
        <i class="fas fa-fw fa-box"></i>
        <span>Status Pesanan</span>
        @php $pesananCount = \App\Models\Pesanan::whereIn('status', ['menunggu','diproses','siap_diambil'])->count(); @endphp
        @if($pesananCount > 0)
            <span class="badge badge-warning ml-1">{{ $pesananCount }}</span>
        @endif
    </a>
</li>
<li class="nav-item {{ Request::is('jadwal*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('jadwal.index') }}">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Jadwal & Booking</span>
    </a>
</li>

<li class="nav-item {{ Request::is('antrian*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('antrian.index') }}">
        <i class="fas fa-fw fa-ticket-alt"></i>
        <span>Antrian Digital</span>
    </a>
</li>

        <li class="nav-item {{ Request::is('hutang*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('hutang.index') }}">
        <i class="fas fa-fw fa-file-invoice-dollar"></i>
        <span>Hutang Pelanggan</span>
        @php $hutangCount = \App\Models\Hutang::where('status', 'belum_lunas')->count(); @endphp
        @if($hutangCount > 0)
            <span class="badge badge-danger ml-1">{{ $hutangCount }}</span>
        @endif
    </a>
</li>

        <li class="nav-item {{ Request::is('garansi*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('garansi.index') }}">
        <i class="fas fa-fw fa-shield-alt"></i>
        <span>Garansi</span>
    </a>
</li>

        <li class="nav-item {{ Request::is('resep*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('resep.index') }}">
                <i class="fas fa-fw fa-eye"></i>
                <span>Resep Mata</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('notifikasi*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('notifikasi.index') }}">
        <i class="fas fa-fw fa-bell"></i>
        <span>Notifikasi</span>
        @php $notifCount = \App\Models\Notifikasi::where('sudah_dibaca', false)->count(); @endphp
        @if($notifCount > 0)
            <span class="badge badge-danger ml-1">{{ $notifCount }}</span>
        @endif
    </a>
</li>

<li class="nav-item {{ Request::is('activity-log*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('activity-log.index') }}">
        <i class="fas fa-fw fa-history"></i>
        <span>Activity Log</span>
    </a>
</li>

<li class="nav-item {{ Request::is('reminder*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('reminder.index') }}">
        <i class="fas fa-fw fa-eye"></i>
        <span>Reminder Kontrol Mata</span>
    </a>
</li>

@if(auth()->user()->role == 'admin')
<hr class="sidebar-divider">
<div class="sidebar-heading">Laporan</div>

<li class="nav-item {{ Request::is('pengaturan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pengaturan.index') }}">
        <i class="fas fa-fw fa-cog"></i>
        <span>Pengaturan Toko</span>
    </a>
</li>

<li class="nav-item {{ Request::is('backup*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('backup.index') }}">
        <i class="fas fa-fw fa-database"></i>
        <span>Backup Database</span>
    </a>
</li>

<li class="nav-item {{ Request::is('laba-rugi*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('laba-rugi.index') }}">
        <i class="fas fa-fw fa-chart-line"></i>
        <span>Laba Rugi</span>
    </a>
</li>

<li class="nav-item {{ Request::is('laporan') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('laporan.index') }}">
        <i class="fas fa-fw fa-list-alt"></i>
        <span>Laporan Transaksi</span>
    </a>
</li>

<li class="nav-item {{ Request::is('laporan/kategori*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('laporan.kategori') }}">
        <i class="fas fa-fw fa-tags"></i>
        <span>Laporan Kategori</span>
    </a>
</li>

<li class="nav-item {{ Request::is('laporan/kasir*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('laporan.kasir') }}">
        <i class="fas fa-fw fa-user-tie"></i>
        <span>Laporan Kasir</span>
    </a>
</li>

<li class="nav-item {{ Request::is('laporan/keuangan*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('laporan.keuangan') }}">
        <i class="fas fa-fw fa-money-bill-wave"></i>
        <span>Laporan Keuangan</span>
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

                    {{-- Dark Mode Toggle --}}
                    <li class="nav-item d-flex align-items-center mx-2">
                        <a href="#" id="darkModeToggle" class="nav-link dark-mode-toggle" title="Toggle Dark Mode">
                            <i class="fas fa-moon" id="darkModeIcon"></i>
                        </a>
                    </li>

                    {{-- Language Switcher --}}

                    {{-- Language Switcher --}}
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe fa-fw"></i>
                            <span class="ml-1">{{ app()->getLocale() == 'id' ? '🇮🇩 ID' : '🇬🇧 EN' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="langDropdown">
                            <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}"
                               href="{{ route('lang.switch', 'id') }}">
                                🇮🇩 Bahasa Indonesia
                            </a>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                               href="{{ route('lang.switch', 'en') }}">
                                🇬🇧 English
                            </a>
                        </div>
                    </li>



                    <!-- Notifikasi Stok -->
@php
    $belumDibacaCount = \App\Models\Notifikasi::where('sudah_dibaca', false)->count();
@endphp
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown"
       role="button" data-toggle="dropdown">
        <i class="fas fa-bell fa-fw"></i>
        @if($belumDibacaCount > 0)
            <span class="badge badge-danger badge-counter">{{ $belumDibacaCount }}</span>
        @endif
    </a>
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in">
        <h6 class="dropdown-header"
            style="background: linear-gradient(135deg, #1a3a5c, #2d5f8a);">
            Notifikasi
        </h6>
        @forelse(\App\Models\Notifikasi::where('sudah_dibaca', false)->latest()->take(5)->get() as $n)
            <a class="dropdown-item d-flex align-items-center"
               href="{{ route('notifikasi.index') }}">
                <div class="mr-3">
                    <div class="rounded-circle p-2
                        {{ $n->tipe == 'stok' ? 'bg-warning' : ($n->tipe == 'pelanggan' ? 'bg-info' : 'bg-primary') }}
                        text-white"
                        style="width:35px; height:35px; display:flex;
                               align-items:center; justify-content:center;">
                        <i class="fas fa-{{ $n->tipe == 'stok' ? 'box' : ($n->tipe == 'pelanggan' ? 'user' : 'bell') }} fa-sm"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ $n->created_at->diffForHumans() }}</div>
                    <span class="font-weight-bold small">{{ $n->judul }}</span>
                </div>
            </a>
        @empty
            <div class="dropdown-item text-center text-muted py-3">
                <i class="fas fa-bell-slash mr-1"></i>
                Tidak ada notifikasi baru
            </div>
        @endforelse
        <a class="dropdown-item text-center small text-gray-500"
           href="{{ route('notifikasi.index') }}">
            Lihat Semua Notifikasi
        </a>
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
    /* ===== GLOBAL ANIMATIONS & TRANSITIONS ===== */

    /* Page transition — semua halaman fade in */
    #content-wrapper {
        animation: pageFadeIn 0.3s ease;
    }

    @keyframes pageFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Card hover lebih smooth */
    .card {
        transition: transform 0.25s ease, box-shadow 0.25s ease !important;
    }

    /* Tombol - semua tombol punya efek */
    .btn {
        transition: all 0.2s ease !important;
        position: relative;
        overflow: hidden;
    }

    .btn:active {
        transform: scale(0.97) !important;
    }

    /* Ripple effect pada tombol */
    .btn::after {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        width: 0; height: 0;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.4s ease, height 0.4s ease, opacity 0.4s ease;
        opacity: 0;
    }

    .btn:active::after {
        width: 200px;
        height: 200px;
        opacity: 0;
    }

    /* Sidebar nav link transition */
    .sidebar .nav-item .nav-link {
        transition: all 0.2s ease !important;
    }

    /* Table row hover smooth */
    .table tbody tr {
        transition: background 0.15s ease;
    }

    /* Badge pulse untuk notifikasi */
    .badge-counter {
        animation: badgePulse 2s infinite;
    }

    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50%       { transform: scale(1.15); }
    }

    /* Form control focus smooth */
    .form-control {
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }

    /* Alert slide in */
    .alert {
        animation: alertSlideIn 0.4s ease;
    }

    @keyframes alertSlideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Loading spinner global */
    .loading-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .loading-overlay.active {
        opacity: 1;
        pointer-events: all;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #e8ecf0;
        border-top-color: #1a3a5c;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Tooltip lebih smooth */
    [title] { cursor: help; }

    /* Stat card number counter effect */
    .stat-number {
        display: inline-block;
        transition: transform 0.3s ease;
    }

    /* Scrollbar smooth */
    html { scroll-behavior: smooth; }

    /* Modal fade lebih smooth */
    .modal.fade .modal-dialog {
        transition: transform 0.25s ease, opacity 0.25s ease !important;
        transform: translateY(-20px);
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
    }

    /* Dropdown menu smooth */
    .dropdown-menu {
        animation: dropdownFadeIn 0.2s ease;
        transform-origin: top;
    }

    @keyframes dropdownFadeIn {
        from { opacity: 0; transform: scaleY(0.95); }
        to   { opacity: 1; transform: scaleY(1); }
    }

    /* Active sidebar item indicator */
    .sidebar .nav-item.active .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: #00b4d8;
        border-radius: 0 3px 3px 0;
        animation: slideInLeft 0.3s ease;
    }

    @keyframes slideInLeft {
        from { height: 0; opacity: 0; }
        to   { height: 60%; opacity: 1; }
    }

    /* Toast notification style */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #1a3a5c;
        color: white;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 14px;
        box-shadow: 0 8px 25px rgba(26,58,92,0.3);
        z-index: 9999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 350px;
    }

    .toast-notification.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast-notification.success { background: #1a7a4a; }
    .toast-notification.error   { background: #9b2335; }
    .toast-notification.warning { background: #8a6000; }
</style>

{{-- Loading Overlay --}}
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<script>
    // ================================================
    // LOADING OVERLAY — tampil saat pindah halaman
    // ================================================
    document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"])').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('javascript') && !this.classList.contains('dropdown-toggle')) {
                document.getElementById('loadingOverlay').classList.add('active');
            }
        });
    });

    // Sembunyikan loading saat halaman selesai load
    window.addEventListener('load', function() {
        document.getElementById('loadingOverlay').classList.remove('active');
    });

    // ================================================
    // AUTO-DISMISS ALERT setelah 4 detik
    // ================================================
    setTimeout(function() {
        document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        });
    }, 4000);

    // ================================================
    // TOAST NOTIFICATION — gantikan alert session
    // ================================================
    function showToast(message, type = 'success') {
        const icons = {
            success : '✅',
            error   : '❌',
            warning : '⚠️',
        };

        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `<span>${icons[type] || '✅'}</span><span>${message}</span>`;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }

    // ================================================
    // KONFIRMASI HAPUS yang lebih cantik
    // ================================================
    document.querySelectorAll('button[onclick*="confirm"]').forEach(btn => {
        const originalOnclick = btn.getAttribute('onclick');
        if (originalOnclick && originalOnclick.includes('confirm(')) {
            const message = originalOnclick.match(/confirm\(['"](.+?)['"]\)/)?.[1] || 'Yakin melakukan aksi ini?';
            btn.removeAttribute('onclick');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (window.confirm(message)) {
                    this.closest('form')?.submit();
                }
            });
        }
    });
</script>

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

<script>
    // ================================================
    // DARK MODE TOGGLE
    // ================================================
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon   = document.getElementById('darkModeIcon');
    const body           = document.body;

    // Cek preferensi tersimpan
    if (localStorage.getItem('darkMode') === 'true') {
        body.classList.add('dark-mode');
        darkModeIcon.classList.remove('fa-moon');
        darkModeIcon.classList.add('fa-sun');
    }

    darkModeToggle.addEventListener('click', function(e) {
        e.preventDefault();
        body.classList.toggle('dark-mode');

        const isDark = body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDark);

        if (isDark) {
            darkModeIcon.classList.remove('fa-moon');
            darkModeIcon.classList.add('fa-sun');
        } else {
            darkModeIcon.classList.remove('fa-sun');
            darkModeIcon.classList.add('fa-moon');
        }
    });
</script>

<script>
    // ================================================
    // REGISTER SERVICE WORKER (PWA)
    // ================================================
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('Service Worker registered');
                })
                .catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
        });
    }

    // ================================================
    // TOMBOL INSTALL PWA (muncul otomatis kalau bisa install)
    // ================================================
    let deferredPrompt;
    const installBanner = document.createElement('div');
    installBanner.id = 'pwaInstallBanner';
    installBanner.style.cssText = `
        position: fixed;
        bottom: 20px;
        left: 20px;
        right: 20px;
        max-width: 380px;
        margin: 0 auto;
        background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
        color: white;
        padding: 16px 20px;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(26,58,92,0.4);
        display: none;
        align-items: center;
        gap: 12px;
        z-index: 9998;
        animation: slideUpBanner 0.4s ease;
    `;
    installBanner.innerHTML = `
        <div style="font-size: 28px;">👓</div>
        <div style="flex: 1;">
            <div style="font-weight: bold; font-size: 14px;">Install Optik Nisa</div>
            <div style="font-size: 12px; opacity: 0.8;">Akses lebih cepat dari home screen</div>
        </div>
        <button id="btnInstallPwa" style="
            background: #00b4d8;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
        ">Install</button>
        <button id="btnCloseInstall" style="
            background: transparent;
            color: rgba(255,255,255,0.6);
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding: 0 5px;
        ">&times;</button>
    `;
    document.body.appendChild(installBanner);

    const styleSlide = document.createElement('style');
    styleSlide.textContent = `
        @keyframes slideUpBanner {
            from { transform: translateY(100px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }
    `;
    document.head.appendChild(styleSlide);

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        installBanner.style.display = 'flex';
    });

    document.getElementById('btnInstallPwa').addEventListener('click', async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            deferredPrompt = null;
            installBanner.style.display = 'none';
        }
    });

    document.getElementById('btnCloseInstall').addEventListener('click', () => {
        installBanner.style.display = 'none';
    });

    window.addEventListener('appinstalled', () => {
        installBanner.style.display = 'none';
    });
</script>


@stack('scripts')
</body>
</html>