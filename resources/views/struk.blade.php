<h2>Transaksi Berhasil</h2>

<h3>Detail Transaksi</h3>

@foreach($keranjang as $k)

<p>

{{ $k['barang'] }}

|

{{ $k['qty'] }}

|

{{ $k['harga'] }}

|

Subtotal : {{ $k['subtotal'] }}

</p>

@endforeach


<hr>

<h2>Total : Rp {{ $total }}</h2>

<button onclick="window.print()">
Cetak Struk
</button>

<a href="/kasir">
Transaksi Baru
</a>