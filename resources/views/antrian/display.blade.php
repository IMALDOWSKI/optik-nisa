<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian - Optik Nisa</title>
    <meta http-equiv="refresh" content="5">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #1a3a5c, #0d1f33);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .logo span { color: #00b4d8; }

        .label-sedang {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 4px;
            opacity: 0.7;
            margin-bottom: 10px;
        }

        .nomor-besar {
            font-size: 180px;
            font-weight: 900;
            line-height: 1;
            color: #00b4d8;
            text-shadow: 0 0 40px rgba(0,180,216,0.5);
            margin-bottom: 10px;
        }

        .nama-pelanggan {
            font-size: 28px;
            opacity: 0.9;
            margin-bottom: 50px;
        }

        .antrian-berikutnya {
            background: rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 20px 40px;
            text-align: center;
        }

        .antrian-berikutnya h4 {
            font-size: 18px;
            letter-spacing: 2px;
            opacity: 0.6;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .daftar-berikutnya {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .nomor-kecil {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 32px;
            font-weight: bold;
        }

        .kosong {
            font-size: 32px;
            opacity: 0.5;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="logo">👓 OPTIK <span>NISA</span></div>

    @if($sedangDilayani)
        <div class="label-sedang">Sedang Dilayani</div>
        <div class="nomor-besar">{{ $sedangDilayani->nomor_antrian }}</div>
        <div class="nama-pelanggan">
            {{ $sedangDilayani->nama_pelanggan ?? 'Pelanggan' }} —
            {{ $sedangDilayani->labelKeperluan() }}
        </div>
    @else
        <div class="label-sedang">Menunggu Panggilan</div>
        <div class="nomor-besar">-</div>
        <div class="kosong">Belum ada antrian yang dipanggil</div>
    @endif

    @if($menunggu->count() > 0)
    <div class="antrian-berikutnya">
        <h4>Antrian Berikutnya</h4>
        <div class="daftar-berikutnya">
            @foreach($menunggu as $m)
            <div class="nomor-kecil">{{ $m->nomor_antrian }}</div>
            @endforeach
        </div>
    </div>
    @endif

</body>
</html>