<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class OwnerController extends Controller
{
    public function index()
    {
        $user = Session::get('user');

        if(!$user || $user->role != 'owner'){
            return redirect('/login');
        }

        // PBI-019 & PBI-020: Mengambil data omzet bulanan & tahunan
        $laporanKonsolidasi = DB::table('transaksi')
            ->select(
                DB::raw('YEAR(waktu) as tahun'),
                DB::raw('MONTHNAME(waktu) as bulan'),
                DB::raw('MONTH(waktu) as bulan_angka'),
                DB::raw('SUM(totalharga) as total_omzet'),
                DB::raw('COUNT(idtransaksi) as total_transaksi')
            )
            ->groupBy('tahun', 'bulan', 'bulan_angka')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan_angka', 'desc')
            ->get();

        return view('Dashboardowner', compact('laporanKonsolidasi'));
    }
}