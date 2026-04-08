<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; 
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function exportExcel()
{
    $laporan = DB::table('transaksi')
        ->select(
            DB::raw('YEAR(waktu) as tahun'),
            DB::raw('MONTHNAME(waktu) as bulan'),
            DB::raw('SUM(totalharga) as total_omzet'),
            DB::raw('COUNT(idtransaksi) as total_transaksi')
        )
        ->groupBy('tahun', 'bulan')
        ->get();

    $response = new StreamedResponse(function() use ($laporan) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Tahun', 'Bulan', 'Jumlah Transaksi', 'Total Omzet']);

        foreach ($laporan as $row) {
            fputcsv($handle, [$row->tahun, $row->bulan, $row->total_transaksi, $row->total_omzet]);
        }
        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="Laporan_Omzet.csv"');

    return $response;
}

}