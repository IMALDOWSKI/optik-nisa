<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error | Optik Nisa</title>
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

        .container { text-align: center; padding: 2rem; }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            color: rgba(255,255,255,0.15);
            letter-spacing: -5px;
        }

        .icon {
            font-size: 4rem;
            margin: 1rem 0;
            color: #e74c3c;
        }

        h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem; }

        p {
            color: rgba(255,255,255,0.7);
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
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
        }

        .btn-home:hover {
            background: white;
            color: #1a3a5c;
            transform: translateY(-2px);
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

        <div class="error-code">500</div>

        <div class="icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <h1>Terjadi Kesalahan Server!</h1>
        <p>
            Maaf, terjadi kesalahan pada sistem.<br>
            Tim teknis kami sedang memperbaikinya.
        </p>

        <a href="{{ url('/dashboard') }}" class="btn-home">
            <i class="fas fa-home mr-2"></i>Ke Dashboard
        </a>
    </div>
</body>
</html>