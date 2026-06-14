<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Optik Nisa</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f1923;
        }

        /* ===== LEFT PANEL ===== */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #1a3a5c 0%, #0f2340 50%, #051525 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(0,180,216,0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(26,58,92,0.3) 0%, transparent 50%);
            animation: bgMove 8s ease-in-out infinite alternate;
        }

        @keyframes bgMove {
            0%   { transform: translate(0, 0); }
            100% { transform: translate(30px, -20px); }
        }

        .left-panel .content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
        }

        .brand-logo {
            font-size: 64px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 20px rgba(0,180,216,0.4));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }

        .brand-name {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #ffffff, #00b4d8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-tagline {
            font-size: 1rem;
            opacity: 0.6;
            letter-spacing: 2px;
            margin-bottom: 50px;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: left;
            width: 100%;
            max-width: 280px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.75);
            font-size: 0.9rem;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            background: rgba(0,180,216,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00b4d8;
            font-size: 14px;
            flex-shrink: 0;
        }

        /* Decorative circles */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(0,180,216,0.1);
        }

        .deco-circle-1 {
            width: 300px; height: 300px;
            top: -100px; right: -100px;
        }

        .deco-circle-2 {
            width: 200px; height: 200px;
            bottom: 50px; left: -80px;
        }

        .deco-circle-3 {
            width: 150px; height: 150px;
            top: 50%; right: 30px;
            transform: translateY(-50%);
        }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            width: 480px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
            width: 100%;
        }

        .login-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a3a5c;
            margin-bottom: 6px;
        }

        .login-header p {
            color: #888;
            font-size: 0.9rem;
        }

        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 13px 14px 13px 40px;
            border: 2px solid #e8ecf0;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #333;
            transition: all 0.3s;
            outline: none;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: #1a3a5c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(26,58,92,0.08);
        }

        .form-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
        }

        .form-remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #1a3a5c;
            cursor: pointer;
        }

        .form-remember label {
            font-size: 0.85rem;
            color: #666;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a3a5c, #2d5f8a);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before { left: 100%; }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26,58,92,0.35);
        }

        .btn-login:active { transform: translateY(0); }

        .login-footer {
            margin-top: 25px;
            text-align: center;
        }

        .login-footer a {
            color: #1a3a5c;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover { text-decoration: underline; }

        .error-message {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #c53030;
            font-size: 0.85rem;
        }

        .copyright {
            margin-top: 40px;
            color: #bbb;
            font-size: 0.75rem;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 40px 30px; }
        }
    </style>
</head>
<body>

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="deco-circle deco-circle-1"></div>
        <div class="deco-circle deco-circle-2"></div>
        <div class="deco-circle deco-circle-3"></div>

        <div class="content">
            <div class="brand-logo">👓</div>
            <div class="brand-name">Optik Nisa</div>
            <div class="brand-tagline">Sistem Manajemen Optik</div>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span>Manajemen Transaksi & Penjualan</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <span>Kelola Stok & Produk Optik</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <span>Data Pelanggan & Member</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Laporan & Analisa Keuangan</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <span>Resep Mata & Reminder Kontrol</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="login-header">
            <h2>Selamat Datang 👋</h2>
            <p>Masuk ke sistem manajemen Optik Nisa</p>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
        <div class="error-message">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}"
                           placeholder="admin@optiknisa.com"
                           required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            <div class="form-remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya selama 30 hari</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt mr-2"></i>
                MASUK KE SISTEM
            </button>
        </form>

        <div class="login-footer">
            <a href="{{ route('password.request') }}">
                <i class="fas fa-key mr-1"></i>Lupa password?
            </a>
        </div>

        <div class="copyright">
            &copy; {{ date('Y') }} Optik Nisa — Sistem Manajemen Optik
        </div>
    </div>

</body>
</html>