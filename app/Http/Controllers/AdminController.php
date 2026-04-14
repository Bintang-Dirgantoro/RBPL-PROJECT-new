<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        if(!$user || $user->role != 'admin') return redirect('/login');

        // Mengambil data untuk tabel verifikasi
        $laporan = DB::table('laporan_harian')->orderBy('created_at', 'desc')->get();
        return view('verifadmin', compact('laporan'));
    }

    public function verifikasi(Request $request, $id) {
        // Ambil data laporan berdasarkan ID untuk mendapatkan total_omzet sistem
        $laporan = DB::table('laporan_harian')->where('id', $id)->first();
        
        $omzetSistem = $laporan->total_omzet;
        $pendapatanReal = $request->pendapatan_real;
        
        // Hitung selisih: Sistem - Real
        $selisih = $omzetSistem - $pendapatanReal;

        // Update database dengan kolom baru
        DB::table('laporan_harian')->where('id', $id)->update([
            'status' => $request->status, // Mengambil ACC atau ditolak
            'pendapatan_real' => $pendapatanReal,
            'selisih' => $selisih,
            'alasan' => $request->alasan,
            'updated_at' => now()
        ]);

        return redirect('/verifadmin')->with('success', 'Laporan berhasil diperbarui!');
    }
}