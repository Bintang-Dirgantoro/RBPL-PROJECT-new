<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Proteksi Halaman
        $user = Session::get('user');
        if(!$user || $user->role != 'admin'){
            return redirect('/login');
        }

        // 2. PBI-016: Mengambil semua laporan dari kasir untuk ditampilkan
        $laporan = DB::table('laporan_harian')
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Kirim data ke view
        return view('verifadmin', compact('laporan'));
    }

    // 4. PBI-017 & PBI-018: Fungsi untuk Proses ACC atau Tolak
    public function verifikasi(Request $request, $id)
{
    DB::table('laporan_harian')
        ->where('id', $id)
        ->update([
            'status' => $request->status // Hapus baris updated_at di sini
        ]);

    $pesan = $request->status == 'ACC' ? 'Laporan Berhasil di-ACC' : 'Laporan telah Ditolak';
    return back()->with('success', $pesan);
}
}