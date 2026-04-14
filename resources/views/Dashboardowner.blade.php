<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - Konsolidasi Laporan</title>
    <style>
        :root {
            --primary: #0f172a;
            --accent: #3b82f6;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        body { 
            font-family: 'Inter', system-ui, sans-serif; 
            background-color: var(--bg); 
            color: var(--text-main);
            margin: 0;
            padding: 0;
        }

        /* Navbar Style */
        .owner-nav {
            background: #0f172a;
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .container-nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .avatar {
            width: 32px; height: 32px; background: #3b82f6;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 0.8rem;
        }
        .btn-logout-minimal {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            padding: 6px 12px;
            border: 1px solid #334155;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .btn-logout-minimal:hover { color: #f87171; border-color: #7f1d1d; background: #450a0a; }

        /* Content Layout */
        .dashboard-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 2rem 2rem 2rem; }

        .header-section { margin-bottom: 2rem; }
        .header-section h1 { margin: 0; font-size: 1.8rem; letter-spacing: -0.025em; }
        .header-section p { color: var(--text-muted); margin-top: 0.5rem; }

        .grid-stats { 
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 1.5rem; 
            margin-bottom: 2rem; 
        }

        .card { 
            background: var(--surface); 
            padding: 1.5rem; 
            border-radius: 12px; 
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .table-container { overflow-x: auto; margin-top: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #f8fafc; 
            text-align: left; 
            padding: 12px 16px; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
        }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        tr:hover { background-color: #f8fafc; }

        .btn-export {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: #16a34a;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: opacity 0.2s;
        }
        .btn-export:hover { opacity: 0.9; }

        .chart-container { margin-top: 1rem; min-height: 300px; }
    </style>
</head>
<body>
    <nav class="owner-nav">
        <div class="container-nav">
            <div class="user-info">
                <div class="avatar">O</div>
                <span style="font-weight: 600;">Owner Dashboard</span>
            </div>
            <a href="/logout" class="btn-logout-minimal">Logout</a>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="header-section">
            <h1>Laporan Konsolidasi</h1>
            <p>Pemantauan performa bisnis bulanan & tahunan secara real-time</p>
        </div>

        <div class="grid-stats">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="margin:0; font-size: 1.25rem;">Visualisasi Omzet</h2>
                    <a href="/owner/export-excel" class="btn-export">Ekspor CSV / Excel</a>
                </div>
                <div class="chart-container">
                    <canvas id="omzetChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top:0; margin-bottom: 1.5rem;">Rincian Riwayat Laporan</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Omzet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanKonsolidasi as $laporan)
                        <tr>
                            <td style="font-weight: 600;">{{ $laporan->tahun }}</td>
                            <td>{{ $laporan->bulan }}</td>
                            <td>{{ $laporan->total_transaksi }} Transaksi</td>
                            <td style="color: var(--accent); font-weight: 700;">Rp {{ number_format($laporan->total_omzet, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('omzetChart').getContext('2d');
        const dataLaporan = @json($laporanKonsolidasi);
        
        const labels = dataLaporan.map(item => item.bulan + ' ' + item.tahun).reverse();
        const omzet = dataLaporan.map(item => item.total_omzet).reverse();

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Omzet (Rp)',
                    data: omzet,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 14 },
                        bodyFont: { size: 14 },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Omzet: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>