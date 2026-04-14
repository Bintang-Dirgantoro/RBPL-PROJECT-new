<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Verifikasi Laporan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        :root {
            --primary: #2563eb;
            --nav-bg: #0f172a;
            --bg: #f4f7fa;
            --surface: #ffffff;
            --text: #2d3436;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 0;
        }

        /* Navbar Style (Matching POS Input) */
        .main-navbar {
            background: var(--nav-bg);
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand { 
            font-weight: 800; 
            letter-spacing: 1px; 
            font-size: 1.1rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #475569;
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }

        .btn-logout-nav {
            color: #fca5a5;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 14px;
            border: 1px solid #7f1d1d;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-logout-nav:hover { 
            background: #7f1d1d; 
            color: white; 
        }

        /* Verifikasi Content */
        .container { 
            max-width: 1000px; 
            margin: 40px auto; 
            padding: 0 20px;
        }
        
        .card {
            background: white; border-radius: 16px; padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 25px;
            position: relative; overflow: hidden;
        }

        .status-banner {
            position: absolute; top: 0; right: 0; padding: 8px 20px;
            font-size: 11px; font-weight: 800; text-transform: uppercase;
            border-bottom-left-radius: 12px;
        }
        .banner-pending { background: #ffeaa7; color: #d35400; }
        .banner-acc { background: #55efc4; color: #00b894; }
        .banner-ditolak { background: #ff7675; color: white; }

        .grid-verif {
            display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
        }

        .info-box {
            border: 1px solid #e0e6ed; border-radius: 12px; padding: 15px; margin-bottom: 10px;
        }

        .label { font-size: 11px; color: #636e72; font-weight: 600; text-transform: uppercase; }
        .value { font-size: 18px; font-weight: 700; color: var(--text); display: block; }
        .value.sistem { color: #2ecc71; }

        .selisih-box {
            background: #f1f2f6; border-radius: 12px; padding: 15px; border: 1px solid #dfe6e9;
        }
        .selisih-box.warning { background: #fff3f3; color: #e74c3c; border-color: #ffcccc; }

        input[type="number"], textarea {
            width: 100%; border: 1px solid #dfe6e9; border-radius: 8px; padding: 12px;
            font-family: inherit; font-size: 14px; margin-top: 5px; background: #fff; box-sizing: border-box;
        }

        .btn-submit {
            background: #2d3436; color: white; border: none; padding: 14px;
            border-radius: 8px; font-weight: 700; cursor: pointer; width: 100%;
            margin-top: 15px; transition: 0.3s;
        }
        .btn-submit:hover { background: #000; transform: translateY(-2px); }

        /* Custom Radio Buttons */
        .radio-group { display: flex; gap: 10px; margin: 15px 0; justify-content: center; }
        .radio-group input { display: none; }
        .radio-group label {
            padding: 10px 30px; border-radius: 8px; cursor: pointer; font-weight: 700;
            border: 2px solid #dfe6e9; transition: 0.2s;
        }
        .radio-group input[value="ACC"]:checked + label { background: #55efc4; border-color: #00b894; color: #004b23; }
        .radio-group input[value="ditolak"]:checked + label { background: #ff7675; border-color: #d63031; color: white; }
    </style>
</head>
<body>

    <nav class="main-navbar">
        <span class="brand">POS SYSTEM v1.0 | ADMIN</span>
        <div class="nav-right">
            <a href="/logout" class="btn-logout-nav">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2 style="margin-bottom: 30px;">Data Verifikasi Laporan</h2>

        @foreach($laporan as $l)
            <div class="card">
                <div class="status-banner banner-{{ strtolower($l->status) }}">
                    {{ $l->status }}
                </div>

                <div style="margin-bottom: 20px;">
                    <h4 style="margin:0;">Laporan Tanggal: {{ $l->tanggal_laporan }}</h4>
                    <p style="font-size:12px; color:#b2bec3; margin:0;">ID Laporan: #{{ $l->id }}</p>
                </div>

                @if($l->status == 'pending')
                    <form action="{{ route('admin.verifikasi', $l->id) }}" method="POST">
                        @csrf
                        <div class="grid-verif">
                            <div class="box-kiri">
                                <div class="info-box">
                                    <span class="label">Omzet Sistem</span>
                                    <span class="value sistem">Rp {{ number_format($l->total_omzet, 0, ',', '.') }}</span>
                                </div>
                                <div class="info-box">
                                    <span class="label">Total Transaksi</span>
                                    <span class="value">{{ $l->total_transaksi }} Transaksi</span>
                                </div>
                            </div>

                            <div class="box-kanan">
                                <span class="label">Pendapatan Real (Uang Fisik)</span>
                                <input type="number" name="pendapatan_real" id="real_{{ $l->id }}" 
                                       oninput="hitung('{{ $l->id }}', {{ $l->total_omzet }})" placeholder="Input nominal..." required>
                                
                                <div id="box_s_{{ $l->id }}" class="selisih-box" style="margin-top:10px;">
                                    <span class="label">Selisih Otomatis</span>
                                    <span class="value" id="text_s_{{ $l->id }}">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top:20px; border-top: 1px solid #eee; padding-top:20px;">
                            <div class="radio-group">
                                <input type="radio" name="status" value="ACC" id="acc_{{ $l->id }}" required>
                                <label for="acc_{{ $l->id }}">SETUJUI</label>

                                <input type="radio" name="status" value="ditolak" id="tolak_{{ $l->id }}">
                                <label for="tolak_{{ $l->id }}">TOLAK</label>
                            </div>
                            <textarea name="alasan" rows="2" placeholder="Tambahkan catatan atau alasan..."></textarea>
                            <button type="submit" class="btn-submit">SIMPAN VERIFIKASI</button>
                        </div>
                    </form>
                @else
                    <div class="grid-verif">
                        <div class="info-box">
                            <span class="label">Total Omzet Sistem</span>
                            <span class="value">Rp {{ number_format($l->total_omzet, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box" style="background: #f8f9fa;">
                            <span class="label">Uang Fisik (Real)</span>
                            <span class="value">Rp {{ number_format($l->pendapatan_real ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="info-box" style="margin-top:10px; border-style: dashed;">
                        <span class="label">Catatan Admin</span>
                        <p style="margin:5px 0 0 0; font-style: italic; color: #636e72;">"{{ $l->alasan ?? 'Tidak ada catatan' }}"</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <script>
    function hitung(id, omzet) {
        let real = document.getElementById('real_' + id).value;
        let sBox = document.getElementById('box_s_' + id);
        let sText = document.getElementById('text_s_' + id);
        let selisih = omzet - real;

        sText.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(selisih);

        if (selisih != 0) {
            sBox.classList.add('warning');
        } else {
            sBox.classList.remove('warning');
        }
    }
    </script>

</body>
</html>