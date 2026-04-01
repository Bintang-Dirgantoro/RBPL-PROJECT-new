<h2>Otorisasi Pembayaran Debit</h2>
<p>Silakan minta pelanggan memasukkan PIN pada mesin EDC (Simulasi)</p>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="/kasir/pin" method="POST">
    @csrf
    <input type="password" 
           name="pin" 
           placeholder="Masukkan PIN" 
           required 
           autofocus>
           
    <button type="submit">Proses Pembayaran</button>
</form>

<br>
<a href="/kasir">Batal</a>