<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome - POS System</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #e2e5e8;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --surface: #ffffff;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .hero-card {
            background: var(--surface);
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border: 1px solid #e2e8f0;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: #dbeafe;
            color: var(--primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            font-weight: 800;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            letter-spacing: -0.025em;
            color: var(--text-main);
        }

        p {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
        }

        .nav-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            display: block;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .btn-login {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .btn-logout {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .btn-logout:hover {
            background-color: #fecaca;
        }

        .footer-text {
            margin-top: 3rem;
            font-size: 0.85rem;
            color: #94a3b8;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="hero-card">
        <div class="logo-placeholder">POS</div>
        <h1>Project RBPL</h1>
        <p>Sistem manajemen Point of Sale terintegrasi untuk efisiensi operasional bisnis Anda.</p>
        
        <div class="nav-actions">
            <a href="/login" class="btn btn-login">Masuk ke Sistem</a>
            {{-- <a href="/logout" class="btn btn-logout">Keluar / Sesi Selesai</a> --}}
        </div>

        <div class="footer-text">
            &copy; 2026 RBPL Dev Team. All rights reserved.
        </div>
    </div>
</body>
</html>