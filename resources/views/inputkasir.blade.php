<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Point of Sale</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --success: #22c55e;
            --danger: #ef4444;
            --bg: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --nav-bg: #0f172a;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        /* Navbar Style */
        .main-navbar {
            background: var(--nav-bg);
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 100;
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

        /* Layout */
        .top-bar {
            background: var(--surface);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .main-container {
            display: grid;
            grid-template-columns: 1fr 420px;
            flex: 1;
            overflow: hidden;
        }

        /* Left Side: Product Input */
        .product-section {
            padding: 2rem;
            overflow-y: auto;
        }

        .input-card {
            background: var(--surface);
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .form-group { margin-bottom: 1.5rem; }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 0.85rem;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            ring: 2px solid #dbeafe;
        }

        /* Right Side: Cart Panel */
        .cart-panel {
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            box-shadow: -4px 0 15px rgba(0,0,0,0.02);
        }

        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem;
        }

        .cart-item {
            background: var(--bg);
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid transparent;
            transition: border-color 0.2s;
        }

        .cart-item:hover { border-color: var(--border); }

        .item-info h4 { margin: 0 0 0.4rem 0; font-size: 1rem; color: var(--text); }
        .item-info p { margin: 0; color: var(--secondary); font-size: 0.85rem; }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
            background: #f8fafc;
        }

        /* Buttons */
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-primary { background: var(--primary); color: white; width: 100%; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .btn-outline { background: white; border: 1px solid var(--border); color: var(--text); font-size: 0.85rem; }
        .btn-outline:hover { background: var(--bg); border-color: var(--secondary); }

        .btn-danger { 
            background: #fee2e2; 
            color: var(--danger); 
            width: 36px; 
            height: 36px; 
            padding: 0; 
            border-radius: 8px;
        }
        .btn-danger:hover { background: var(--danger); color: white; }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-pay {
            padding: 1.2rem;
            font-size: 0.9rem;
            font-weight: 800;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <nav class="main-navbar">
        <span class="brand">POS SYSTEM v1.0</span>
        <div class="nav-right">
            <a href="/kasir/rekap" class="btn btn-outline">Lihat Rekap Harian</a>
            <a href="/logout" class="btn-logout-nav">Logout</a>
        </div>
    </nav>

    <div class="main-container">
        <section class="product-section">
            <div class="input-card">
                <h2 style="margin: 0 0 1.5rem 0; font-size: 1.5rem;">Input Penjualan</h2>
                <form action="/kasir/tambah" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kode Barang / Barcode</label>
                        <input name="idbarang" class="form-control" placeholder="Scan barcode atau ketik ID barang..." autofocus required>
                    </div>
                    <div class="form-group">
                        <label>Kuantitas (Qty)</label>
                        <input name="qty" type="number" value="1" min="1" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                </form>
            </div>
        </section>

        <aside class="cart-panel">
            <div class="cart-header">
                🛒 Keranjang Belanja
            </div>
            
            <div class="cart-items">
                @forelse($keranjang as $index => $k)
                <div class="cart-item">
                    <div class="item-info">
                        <h4>{{ $k['barang'] }}</h4>
                        <p>{{ $k['qty'] }} x Rp {{ number_format($k['harga']) }}</p>
                        <strong style="color: var(--primary); font-size: 1.1rem;">Rp {{ number_format($k['subtotal']) }}</strong>
                    </div>
                    <form action="/kasir/hapus/{{ $index }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" title="Hapus Barang">✕</button>
                    </form>
                </div>
                @empty
                <div style="text-align: center; color: var(--secondary); margin-top: 3rem;">
                    <p>Keranjang masih kosong</p>
                </div>
                @endforelse
            </div>

            <div class="cart-footer">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <span style="font-weight: 600; color: var(--secondary);">Total Bayar:</span>
                    <span style="font-size: 1.75rem; font-weight: 900; color: var(--text);">
                        @php 
                            $totalSemua = collect($keranjang)->sum('subtotal');
                        @endphp
                        Rp {{ number_format($totalSemua) }}
                    </span>
                </div>

                <form action="/kasir/metode" method="POST">
                    @csrf
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--secondary); margin-bottom: 0.5rem; text-transform: uppercase;">
                        Pilih Metode Pembayaran:
                    </div>
                    <div class="payment-grid">
                        <button name="metode" value="tunai" class="btn btn-pay" style="background: #e0f2fe; color: #0369a1; border: 2px solid #bae6fd;">
                            💵 TUNAI
                        </button>
                        <button name="metode" value="debit" class="btn btn-pay" style="background: #dcfce7; color: #15803d; border: 2px solid #bbf7d0;">
                            💳 DEBIT
                        </button>
                    </div>
                </form>
            </div>
        </aside>
    </div>

</body>
</html>