<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{

    public function index()
    {
        // PROTECT HALAMAN
        $user = Session::get('user');

        if(!$user || $user->role != 'kasir'){
            return redirect('/login');
        }

        $keranjang = Session::get('keranjang', []);

        return view('inputkasir', compact('keranjang'));
    }


    // FR-003 INPUT BARANG
    public function tambahBarang(Request $request)
    {
        $keranjang = Session::get('keranjang', []);

        $keranjang[] = [
            'barang' => $request->barang,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'subtotal' => $request->qty * $request->harga
        ];

        Session::put('keranjang', $keranjang);

        return redirect('/kasir');
    }


    // PILIH METODE PEMBAYARAN
    public function metode(Request $request)
    {
        Session::put('metode', $request->metode);

        if($request->metode == 'debit'){
            return view('inputpin');
        }

        return redirect('/kasir/struk');
    }


    // FR-004 INPUT PIN
    public function inputPin(Request $request)
    {
        if($request->pin != "123456"){
            return back()->with('error','PIN salah');
        }

        return redirect('/kasir/struk');
    }


    // FR-005 CETAK STRUK
    public function struk()
    {
        $keranjang = Session::get('keranjang', []);
        $total = 0;

        foreach($keranjang as $item){
            $total += $item['subtotal'];
        }

        Session::forget('keranjang');

        return view('struk', compact('keranjang','total'));
    }

}