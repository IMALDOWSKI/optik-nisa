<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Optik Nisa</title>

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-glasses"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Optik Nisa</div>
        </a>
        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="/"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">Data Master</div>

        <li class="nav-item {{ Request::is('pelanggan*') ? 'active' : '' }}">
            <a class="nav-link" href="/pelanggan"><i class="fas fa-fw fa-users"></i><span>Pelanggan</span></a>
        </li>
        <li class="nav-item {{ Request::is('produk*') ? 'active' : '' }}">
            <a class="nav-link" href="/produk"><i class="fas fa-fw fa-glasses"></i><span>Produk</span></a>
        </li>
        <li class="nav-item {{ Request::is('transaksi*') ? 'active' : '' }}">
            <a class="nav-link" href="/transaksi"><i class="fas fa-fw fa-shopping-cart"></i><span>Transaksi</span></a>
        </li>
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
                    <li class="nav-item">
                        <span class="nav-link">Selamat Datang, Admin</span>
                    </li>
                </ul>
            </nav>
            <!-- End Topbar -->

            <!-- Page Content -->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
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
                    <span>Optik Nisa &copy; {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- SB Admin 2 JS -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
@stack('scripts')
</body>
</html>