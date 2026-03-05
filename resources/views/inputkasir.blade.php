<h2>Input Barang</h2>

<form action="/kasir/tambah" method="POST">
@csrf

Nama Barang
<input name="barang">

Qty
<input name="qty">

Harga
<input name="harga">

<button type="submit">Tambah Barang</button>

</form>

<hr>


<h3>Keranjang</h3>

@foreach($keranjang as $k)

<p>

{{ $k['barang'] }}

|

Qty : {{ $k['qty'] }}

|

Harga : {{ $k['harga'] }}

|

Subtotal : {{ $k['subtotal'] }}

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