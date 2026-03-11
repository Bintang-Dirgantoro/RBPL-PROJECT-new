<h2>Rekap Omzet Harian</h2>

<table border="1">
<tr>
<th>Tanggal</th>
<th>Jumlah Transaksi</th>
<th>Total Omzet</th>
</tr>

@foreach($rekap as $r)

<tr>
<td>{{ $r->tanggal }}</td>
<td>{{ $r->jumlah_transaksi }}</td>
<td>Rp {{ number_format($r->omzet) }}</td>
</tr>

@endforeach

</table>

<br>

<a href="/kasir">Kembali ke Kasir</a>