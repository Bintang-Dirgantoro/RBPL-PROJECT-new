<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{
    public function index()
    {
        // PROTECT HALAMAN
        $user = Session::get('user');

        if (! $user || $user->role != 'kasir') {
            return redirect('/login');
        }

        $keranjang = Session::get('keranjang', []);

        return view('inputkasir', compact('keranjang'));
    }

    // FR-003 INPUT BARANG
    public function tambahBarang(Request $request)
    {
        $barang = DB::table('barang')
            ->where('idbarang', $request->idbarang)
            ->first();

        if (! $barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }

        $keranjang = Session::get('keranjang', []);

        $found = false;

        foreach ($keranjang as $i => $item) {

            if ($item['barang'] == $barang->nama) {

                $keranjang[$i]['qty'] += $request->qty;

                $keranjang[$i]['subtotal'] =
                    $keranjang[$i]['qty'] * $keranjang[$i]['harga'];

                $found = true;

                break;
            }
        }

        if (! $found) {

            $keranjang[] = [
                'barang' => $barang->nama,
                'qty' => $request->qty,
                'harga' => $barang->harga,
                'subtotal' => $barang->harga * $request->qty,
            ];
        }

        Session::put('keranjang', $keranjang);

        return redirect('/kasir');
    }

    public function hapusBarang($index)
    {
        $keranjang = Session::get('keranjang', []);

        unset($keranjang[$index]);

        $keranjang = array_values($keranjang);

        Session::put('keranjang', $keranjang);

        return redirect('/kasir');
    }

    // PILIH METODE PEMBAYARAN
    public function metode(Request $request)
    {
        Session::put('metode', $request->metode);

        if ($request->metode == 'debit') {
            return view('inputpin');
        }

        return redirect('/kasir/struk');
    }

    // FR-004 INPUT PIN
    public function inputPin(Request $request)
    {
        if ($request->pin != '123456') {
            return back()->with('error', 'PIN salah');
        }

        return redirect('/kasir/struk');
    }

    // FR-005 CETAK STRUK
    public function struk()
    {
        $keranjang = Session::get('keranjang', []);
        $metode = Session::get('metode');

        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['subtotal'];
        }

        // simpan transaksi
        $idtransaksi = DB::table('transaksi')->insertGetId([
            'waktu' => now(),
            'metodepembayaran' => $metode,
            'totalharga' => $total,
        ]);

        // simpan detail transaksi
        foreach ($keranjang as $item) {

            $barang = DB::table('barang')
                ->where('nama', $item['barang'])
                ->first();

            DB::table('detailtransaksi')->insert([
                'idtransaksi' => $idtransaksi,
                'idbarang' => $barang->idbarang,
                'qty' => $item['qty'],
                'hargabeli_skrg' => $item['harga'],
            ]);
        }

        Session::forget('keranjang');

        return view('struk', compact('keranjang', 'total'));
    }

    public function rekapHarian()
    {
        $hariIni = now()->toDateString();

        // Ambil detail transaksi untuk tabel (sesuai desain Figma)
        $detailTransaksi = DB::table('transaksi')
            ->whereDate('waktu', $hariIni)
            ->get();

        // Hitung total untuk box visualisasi
        $totalOmzet = $detailTransaksi->sum('totalharga');
        $jumlahTransaksi = $detailTransaksi->count();

        return view('rekap', compact('detailTransaksi', 'totalOmzet', 'jumlahTransaksi', 'hariIni'));
    }

    // Ambil detail barang untuk modal di halaman rekap
    public function detailTransaksi($id)
    {
        $detail = DB::table('detailtransaksi')
            ->join('barang', 'detailtransaksi.idbarang', '=', 'barang.idbarang')
            ->where('detailtransaksi.idtransaksi', $id)
            ->select('barang.nama', 'detailtransaksi.qty', 'detailtransaksi.hargabeli_skrg as harga')
            ->get();

        return response()->json($detail);
    }

    public function kirimLaporan(Request $request)
    {
        // Cek apakah sudah ada laporan di tabel laporan_harian [cite: 10]
        $cek = DB::table('laporan_harian')
            ->where('tanggal_laporan', $request->tanggal)
            ->first();

        if ($cek) {
            return back()->with('error', 'Laporan hari ini sudah dikirim!');
        }

        // Insert dengan status pending [cite: 10]
        DB::table('laporan_harian')->insert([
            'tanggal_laporan' => $request->tanggal,
            'total_omzet' => $request->omzet,
            'total_transaksi' => $request->jumlah_transaksi,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        return back()->with('success', 'Laporan berhasil dikirim.');
    }
}
