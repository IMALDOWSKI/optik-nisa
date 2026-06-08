<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | Optik Nisa</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #1a3a5c 0%, #0f2340 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .container {
            text-align: center;
            padding: 2rem;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            color: rgba(255,255,255,0.15);
            text-shadow: none;
            letter-spacing: -5px;
        }

        .glasses-icon {
            font-size: 4rem;
            margin: 1rem 0;
            color: #00b4d8;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        p {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .btn-home {
            display: inline-block;
            padding: 12px 30px;
            background: #00b4d8;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 5px;
        }

        .btn-home:hover {
            background: white;
            color: #1a3a5c;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-back {
            display: inline-block;
            padding: 12px 30px;
            background: transparent;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.3s;
            margin: 0 5px;
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
        }

        .brand {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: rgba(255,255,255,0.5);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand">
            <i class="fas fa-glasses mr-2"></i>Optik Nisa
        </div>

        <div class="error-code">404</div>

        <div class="glasses-icon">
            <i class="fas fa-search"></i>
        </div>

        <h1>Halaman Tidak Ditemukan!</h1>
        <p>
            Sepertinya halaman yang kamu cari tidak ada atau sudah dipindahkan.<br>
            Coba kembali ke dashboard.
        </p>

        <div>
            <a href="{{ url('/dashboard') }}" class="btn-home">
                <i class="fas fa-home mr-2"></i>Ke Dashboard
            </a>
            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</body>
</html>