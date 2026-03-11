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
        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['subtotal'];
        }

        Session::forget('keranjang');

        return view('struk', compact('keranjang', 'total'));
    }
}