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
</body>
</html>