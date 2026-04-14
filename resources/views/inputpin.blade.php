<style>
    .edc-container {
        max-width: 350px;
        margin: 50px auto;
        background: #1e293b;
        border-radius: 20px;
        padding: 30px;
        color: white;
        text-align: center;
        border: 8px solid #334155;
    }
    .edc-screen {
        background: #84cc16;
        color: #064e3b;
        padding: 20px;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        margin-bottom: 20px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }
    .pin-input {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 2px solid #064e3b;
        text-align: center;
        font-size: 2rem;
        letter-spacing: 10px;
        color: #064e3b;
        margin: 10px 0;
    }
    .pin-input:focus { outline: none; }
    .btn-process {
        background: #22c55e;
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }
</style>

<div class="edc-container">
    <div class="edc-screen">
        <h3 style="margin:0">OTORISASI DEBIT</h3>
        <p style="font-size: 0.8rem;">Masukkan PIN Pelanggan</p>
        
        @if(session('error'))
            <p style="color: #991b1b; font-size: 0.75rem; font-weight: bold;">{{ session('error') }}</p>
        @endif

        <form action="/kasir/pin" method="POST">
            @csrf
            <input type="password" name="pin" class="pin-input" maxlength="6" required autofocus>
            <button type="submit" class="btn-process">PROSES SEKARANG</button>
        </form>
    </div>
    <a href="/kasir" style="color: #94a3b8; text-decoration: none; font-size: 0.8rem;">Batal Transaksi</a>
</div>