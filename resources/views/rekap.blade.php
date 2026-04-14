<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Harian - POS System</title>
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #1e293b;
            --secondary: #64748b;
            --border: #e2e8f0;
            --nav-bg: #0f172a;
        }

        body { 
            font-family: 'Inter', system-ui, sans-serif; 
            background: var(--bg); 
            color: var(--text);
            margin: 0;
            padding-bottom: 50px;
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
            margin-bottom: 2rem;
        }

        .brand { font-weight: 800; letter-spacing: 1px; }

        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: var(--surface); 
            padding: 2.5rem; 
            border-radius: 16px; 
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); 
            border: 1px solid var(--border);
        }
        
        .header-flex { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem; 
        }
        
        table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; }
        th { 
            text-align: left; 
            padding: 1rem; 
            background: #f1f5f9; 
            color: var(--secondary); 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.05em;
        }
        td { padding: 1.25rem 1rem; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        
        /* Badges */
        .badge { padding: 6px 12px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-acc { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        /* Notification Dropdown */
        .notif-dropdown {
            position: absolute; right: 0; top: 50px; width: 320px;
            background: white; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            border: 1px solid var(--border); z-index: 100; padding: 1.25rem;
            text-align: left;
        }

        /* Buttons */
        .btn-send { 
            background: #16a34a; color: white; padding: 1.25rem; 
            border: none; border-radius: 10px; width: 100%; font-weight: 800; 
            cursor: pointer; transition: all 0.2s; font-size: 1rem;
            box-shadow: 0 4px 0 #15803d;
        }
        .btn-send:hover { background: #15803d; transform: translateY(-1px); }
        .btn-send:active { transform: translateY(2px); box-shadow: none; }

        .btn-outline {
            padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border);
            background: white; cursor: pointer; font-weight: 600; color: var(--text);
            transition: all 0.2s;
        }
        .btn-outline:hover { background: var(--bg); border-color: var(--secondary); }

        .btn-back {
            color: white; text-decoration: none; font-size: 0.9rem; font-weight: 600;
        }
    </style>
</head>
<body>

    <nav class="main-navbar">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="/kasir" class="btn-back">⬅ Kembali ke Kasir</a>
            <span style="opacity: 0.3;">|</span>
            <span class="brand">REKAP POS</span>
        </div>
        <a href="/logout" style="color: #fca5a5; text-decoration: none; font-size: 0.85rem; font-weight: 700;">KELUAR</a>
    </nav>

    <div class="container">
        <div class="header-flex">
            <h2 style="margin:0; font-size: 1.5rem; letter-spacing: -0.025em;">Laporan Transaksi Hari Ini</h2>
            
            <div style="position: relative;">
                <button onclick="toggleNotif()" class="btn-outline">
                    🔔 Status Laporan
                </button>
                
                <div id="box-notif" class="notif-dropdown" style="display:none;">
                    <h4 style="margin: 0 0 1rem 0; font-size: 0.9rem; color: var(--secondary);">3 Laporan Terakhir</h4>
                    @php
                        $notif = DB::table('laporan_harian')->orderBy('created_at', 'desc')->take(3)->get();
                    @endphp
                    @forelse($notif as $n)
                        <div style="padding: 12px 0; border-bottom: 1px solid #f8fafc;">
                            <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <small style="font-weight: 700; color: var(--text);">Lap. {{ $n->tanggal_laporan }}</small>
                                <span class="badge {{ $n->status == 'ACC' ? 'badge-acc' : ($n->status == 'ditolak' ? 'badge-rejected' : 'badge-pending') }}">
                                    {{ $n->status }}
                                </span>
                            </div>
                            <div style="font-size: 0.75rem; color: var(--secondary);">Total: Rp {{ number_format($n->total_omzet) }}</div>
                        </div>
                    @empty
                        <p style="font-size: 0.8rem; color: var(--secondary);">Belum ada riwayat laporan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Metode Pembayaran</th>
                    <th>Total Nominal</th>
                    <th style="text-align: right;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detailTransaksi as $t)
                <tr>
                    <td style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: var(--primary);">#TRX-{{ $t->idtransaksi }}</td>
                    <td>
                        <span style="display: flex; align-items: center; gap: 8px;">
                            {{ $t->metodepembayaran == 'tunai' ? '💵' : '💳' }}
                            <span style="text-transform: uppercase; font-weight: 600; font-size: 0.85rem;">{{ $t->metodepembayaran }}</span>
                        </span>
                    </td>
                    <td style="font-weight: 700;">Rp {{ number_format($t->totalharga) }}</td>
                    <td style="text-align: right;">
                        <button class="btn-outline" style="font-size: 0.75rem; padding: 6px 12px;" onclick="showDetail({{ $t->idtransaksi }})">
                            LIHAT BARANG
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 3rem; color: var(--secondary);">Belum ada transaksi untuk hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="background: #f8fafc; padding: 2rem; border-radius: 12px; margin-top: 2rem; border: 1px dashed var(--border);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <div style="color: var(--secondary); font-size: 0.85rem; font-weight: 600; margin-bottom: 4px;">AKUMULASI OMZET</div>
                    <div style="font-size: 0.8rem; color: var(--secondary);">Total dari {{ $jumlahTransaksi }} Transaksi</div>
                </div>
                <strong style="font-size: 2rem; color: var(--text); letter-spacing: -1px;">Rp {{ number_format($totalOmzet) }}</strong>
            </div>

            <form action="/kasir/kirim-laporan" method="POST">
                @csrf
                <input type="hidden" name="tanggal" value="{{ $hariIni }}">
                <input type="hidden" name="omzet" value="{{ $totalOmzet }}">
                <input type="hidden" name="jumlah_transaksi" value="{{ $jumlahTransaksi }}">
                <button type="submit" class="btn-send">KIRIM LAPORAN KE ADMIN SEKARANG</button>
            </form>
            <p style="text-align: center; font-size: 0.75rem; color: var(--secondary); margin-top: 1rem;">
                Pastikan semua transaksi sudah benar sebelum mengirim laporan harian.
            </p>
        </div>
    </div>

    <script>
        function showDetail(id) {
            fetch('/kasir/detail-transaksi/' + id)
                .then(response => response.json())
                .then(data => {
                    let list = "DETAIL BARANG BELANJA:\n\n";
                    data.forEach(item => { 
                        list += `• ${item.nama}\n  ${item.qty} pcs x Rp ${item.harga.toLocaleString()}\n\n`; 
                    });
                    alert(list);
                })
                .catch(err => alert("Gagal mengambil detail transaksi."));
        }

        function toggleNotif() {
            let x = document.getElementById("box-notif");
            x.style.display = (x.style.display === "none") ? "block" : "none";
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.btn-outline')) {
                let dropdown = document.getElementById("box-notif");
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>