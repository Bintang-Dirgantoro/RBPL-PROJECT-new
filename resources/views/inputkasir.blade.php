<h2>Input Kasir</h2>

<a href="/kasir/rekap">
<button>Lihat Rekap Harian</button>
</a>

<hr>

<h2>Input Barang</h2>

<form action="/kasir/tambah" method="POST">
@csrf

Kode Barang
<input name="idbarang">

Qty
<input name="qty">

<button type="submit">Tambah Barang</button>

</form>
<hr>


<h3>Keranjang</h3>

@foreach($keranjang as $index => $k)

<p>
{{ $k['barang'] }} |
Qty : {{ $k['qty'] }} |
Harga : {{ $k['harga'] }} |
Subtotal : {{ $k['subtotal'] }}

<form action="/kasir/hapus/{{ $index }}" method="POST" style="display:inline;">
@csrf
<button type="submit">Hapus</button>
</form>

</p>

@endforeach


<hr>


<form action="/kasir/metode" method="POST">

@csrf

<button name="metode" value="tunai">
Bayar Tunai
</button>

<button name="metode" value="debit">
Bayar Debit
</button>

</form>