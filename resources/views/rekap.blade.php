<div style="text-align: right;">
    <button onclick="toggleNotif()">🔔 Status Laporan</button>
    <div id="box-notif" style="display:none; border:1px solid #ccc; position:absolute; right:10px; background:white; padding:10px;">
        <h4>Notifikasi Verifikasi</h4>
        @php
            $notif = DB::table('laporan_harian')->orderBy('created_at', 'desc')->take(3)->get();
        @endphp
        @foreach($notif as $n)
            <p>Laporan {{ $n->tanggal_laporan }}: 
               <b style="color: {{ $n->status == 'ACC' ? 'green' : ($n->status == 'ditolak' ? 'red' : 'orange') }}">
               {{ strtoupper($n->status) }}
               </b>
            </p>
        @endforeach
    </div>
</div>

<table border="1" width="100%">
    <tr>
        <th>ID Transaksi</th>
        <th>Metode</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>
    @foreach($detailTransaksi as $t)
    <tr>
        <td>TRX-{{ $t->idtransaksi }}</td>
        <td>{{ $t->metodepembayaran }}</td>
        <td>Rp {{ number_format($t->totalharga) }}</td>
        <td>
            <button onclick="showDetail({{ $t->idtransaksi }})">Lihat Detail</button>
        </td>
    </tr>
    @endforeach
</table>

<form action="/kasir/kirim-laporan" method="POST">
    @csrf
    <input type="hidden" name="tanggal" value="{{ $hariIni }}">
    <input type="hidden" name="omzet" value="{{ $totalOmzet }}">
    <input type="hidden" name="jumlah_transaksi" value="{{ $jumlahTransaksi }}">
    <button type="submit" style="background-color: green; color: white;">Kirim Laporan ke Admin</button>
</form>

<script>
function showDetail(id) {
    fetch('/kasir/detail-transaksi/' + id)
        .then(response => response.json())
        .then(data => {
            let list = "Detail Barang:\n";
            data.forEach(item => {
                list += `- ${item.nama} (${item.qty} pcs) x ${item.harga}\n`;
            });
            alert(list); // Sederhananya pakai alert, atau bisa pakai Modal Bootstrap/Tailwind
        });
}

function toggleNotif() {
    let x = document.getElementById("box-notif");
    x.style.display = (x.style.display === "none") ? "block" : "none";
}
</script>