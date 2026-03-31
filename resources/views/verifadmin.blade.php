<h2>Halaman Verifikasi Admin Keuangan</h2>

@if(session('success'))
    <div style="padding: 10px; background-color: #d4edda; color: #155724; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

<table border="1" width="100%" style="text-align: center;">
    <thead>
        <tr>
            <th>Tanggal Laporan</th>
            <th>Total Omzet</th>
            <th>Total Transaksi</th>
            <th>Status Saat Ini</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $l)
        <tr>
            <td>{{ $l->tanggal_laporan }}</td>
            <td>Rp {{ number_format($l->total_omzet) }}</td>
            <td>{{ $l->total_transaksi }}</td>
            <td>
                <span style="padding: 5px; border-radius: 5px; color: white; background-color: {{ $l->status == 'ACC' ? 'green' : ($l->status == 'ditolak' ? 'red' : 'orange') }}">
                    {{ strtoupper($l->status) }}
                </span>
            </td>
            <td>
                @if($l->status == 'pending')
                    <form action="/admin/verifikasi/{{ $l->id }}" method="POST" style="display:inline;">
                        @csrf <input type="hidden" name="status" value="ACC">
                        <button type="submit">ACC</button>
                    </form>

                    <form action="/admin/verifikasi/{{ $l->id }}" method="POST" style="display:inline;">
                        @csrf <input type="hidden" name="status" value="ditolak">
                        <button type="submit">Tolak</button>
                    </form>
                @else
                    <small>Sudah diproses</small>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>