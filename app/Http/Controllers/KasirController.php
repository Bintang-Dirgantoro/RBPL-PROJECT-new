<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        if (! $user || $user->role != 'kasir') {
            return redirect('/login');
        }
        $keranjang = Session::get('keranjang', []);
        return view('inputkasir', compact('keranjang'));
    }

    public function tambahBarang(Request $request)
    {
        $barang = DB::table('barang')->where('idbarang', $request->idbarang)->first();
        if (!$barang) return back()->with('error', 'Barang tidak ditemukan');

        $keranjang = Session::get('keranjang', []);
        $found = false;
        foreach ($keranjang as $i => $item) {
            if ($item['barang'] == $barang->nama) {
                $keranjang[$i]['qty'] += $request->qty;
                $keranjang[$i]['subtotal'] = $keranjang[$i]['qty'] * $keranjang[$i]['harga'];
                $found = true;
                break;
            }
        }
        if (!$found) {
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
        Session::put('keranjang', array_values($keranjang));
        return redirect('/kasir');
    }

    public function metode(Request $request)
    {
        Session::put('metode', $request->metode);
        if ($request->metode == 'debit') return view('inputpin');
        return redirect('/kasir/struk');
    }

    public function inputPin(Request $request)
    {
        // Apapun PIN yang diinput, kita anggap valid (Simulasi otorisasi Bank)
        // Kita hanya perlu memastikan PIN tidak kosong
        if (!$request->pin) {
            return back()->with('error', 'PIN harus diisi!');
        }

        // Langsung arahkan ke fungsi struk untuk proses simpan database
        return redirect('/kasir/struk');
    }

    // FIX: Transaksi Debit & Tunai Sekarang Terpusat di Sini
    public function struk()
    {
        $keranjang = Session::get('keranjang', []);
        $metode = Session::get('metode');

        if (empty($keranjang)) return redirect('/kasir')->with('error', 'Transaksi kosong.');

        $total = collect($keranjang)->sum('subtotal');

        DB::beginTransaction();
        try {
            $idtransaksi = DB::table('transaksi')->insertGetId([
                'waktu' => now(),
                'metodepembayaran' => $metode ?? 'tunai',
                'totalharga' => $total,
            ]);

            foreach ($keranjang as $item) {
                $barang = DB::table('barang')->where('nama', $item['barang'])->first();
                DB::table('detailtransaksi')->insert([
                    'idtransaksi' => $idtransaksi,
                    'idbarang' => $barang->idbarang,
                    'qty' => $item['qty'],
                    'hargabeli_skrg' => $item['harga'],
                ]);
            }

            DB::commit();
            
            // Hapus session setelah sukses database
            $dataStruk = $keranjang;
            Session::forget(['keranjang', 'metode']);

            return view('struk', ['keranjang' => $dataStruk, 'total' => $total, 'metode' => $metode]);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/kasir')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function rekapHarian()
    {
        $hariIni = now()->toDateString();
        $detailTransaksi = DB::table('transaksi')->whereDate('waktu', $hariIni)->get();
        $totalOmzet = $detailTransaksi->sum('totalharga');
        $jumlahTransaksi = $detailTransaksi->count();

        return view('rekap', compact('detailTransaksi', 'totalOmzet', 'jumlahTransaksi', 'hariIni'));
    }

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
        $cek = DB::table('laporan_harian')->where('tanggal_laporan', $request->tanggal)->first();
        if ($cek) return back()->with('error', 'Laporan hari ini sudah dikirim!');

        DB::table('laporan_harian')->insert([
            'tanggal_laporan' => $request->tanggal,
            'total_omzet' => $request->omzet,
            'total_transaksi' => $request->jumlah_transaksi,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Laporan berhasil dikirim ke Admin.');
    }
}