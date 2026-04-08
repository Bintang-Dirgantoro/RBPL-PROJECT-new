<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - Konsolidasi Laporan</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .card { padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Dashboard Owner</h1>
        <p>Laporan Konsolidasi Bulanan & Tahunan</p>

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
                    <td>{{ $laporan->tahun }}</td>
                    <td>{{ $laporan->bulan }}</td>
                    <td>{{ $laporan->total_transaksi }} Transaksi</td>
                    <td>Rp {{ number_format($laporan->total_omzet, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Grafik Omzet Bulanan</h2>
        <a href="/owner/export-excel" style="padding: 10px; background: green; color: white; text-decoration: none; border-radius: 5px;">Ekspor Excel (CSV)</a>
    </div>
    <canvas id="omzetChart" width="400" height="150"></canvas>
</div>

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
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>