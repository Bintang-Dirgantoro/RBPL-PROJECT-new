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

        // REVISI: Mengambil data HANYA yang sudah di-ACC oleh admin dari tabel laporan_harian
        $laporanKonsolidasi = DB::table('laporan_harian')
            ->select(
                DB::raw('YEAR(tanggal_laporan) as tahun'),
                DB::raw('MONTHNAME(tanggal_laporan) as bulan'),
                DB::raw('MONTH(tanggal_laporan) as bulan_angka'),
                DB::raw('SUM(total_omzet) as total_omzet'),
                DB::raw('SUM(total_transaksi) as total_transaksi')
            )
            ->where('status', 'ACC') // Kunci revisi nomor 1
            ->groupBy('tahun', 'bulan', 'bulan_angka')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan_angka', 'desc')
            ->get();

        return view('Dashboardowner', compact('laporanKonsolidasi'));
    }

    public function exportExcel()
    {
        // REVISI: Export juga hanya data yang sudah divalidasi (ACC)
        $laporan = DB::table('laporan_harian')
            ->select(
                DB::raw('YEAR(tanggal_laporan) as tahun'),
                DB::raw('MONTHNAME(tanggal_laporan) as bulan'),
                DB::raw('SUM(total_omzet) as total_omzet'),
                DB::raw('SUM(total_transaksi) as total_transaksi')
            )
            ->where('status', 'ACC')
            .groupBy('tahun', 'bulan')
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
        $response->headers->set('Content-Disposition', 'attachment; filename="Laporan_Omzet_Valid.csv"');

        return $response;
    }
}