<style>
    body { background: #eee; padding: 20px; font-family: 'Courier New', Courier, monospace; }
    .receipt { 
        background: white; 
        width: 300px; 
        margin: 0 auto; 
        padding: 20px; 
        box-shadow: 0 0 10px rgba(0,0,0,0.1); 
    }
    .text-center { text-align: center; }
    .divider { border-top: 1px dashed #000; margin: 10px 0; }
    .item-row { display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 5px; }
    
    @media print {
        body { background: white; padding: 0; }
        .receipt { width: 100%; box-shadow: none; }
        .no-print { display: none; }
    }
</style>

<div class="receipt">
    <div class="text-center">
        <h2 style="margin:0">TOKO KITA</h2>
        <p style="font-size: 0.8rem;">Jl. Raya Pendidikan No. 124<br>Telp: 021-12345678</p>
    </div>

    <div class="divider"></div>

    @foreach($keranjang as $k)
    <div class="item-row">
        <span>{{ $k['barang'] }} (x{{ $k['qty'] }})</span>
        <span>{{ number_format($k['subtotal']) }}</span>
    </div>
    @endforeach

    <div class="divider"></div>

    <div class="item-row" style="font-weight: bold; font-size: 1.1rem;">
        <span>TOTAL</span>
        <span>Rp {{ number_format($total) }}</span>
    </div>

    <div class="divider"></div>
    <p class="text-center" style="font-size: 0.8rem;">Terima Kasih Atas Kunjungan Anda</p>
    
    <div class="no-print" style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
        <button onclick="window.print()" style="padding: 10px; cursor: pointer; background: #2563eb; color: white; border: none; border-radius: 4px;">Cetak Struk</button>
        <a href="/kasir" style="text-align: center; font-family: sans-serif; font-size: 0.9rem; color: #666;">Kembali ke POS</a>
    </div>
</div>