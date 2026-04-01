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

        $laporan = DB::table('laporan_harian')->orderBy('created_at', 'desc')->get();
        return view('verifadmin', compact('laporan'));
    }

    public function verifikasi(Request $request, $id)
    {
        DB::table('laporan_harian')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Status laporan berhasil diupdate ke: ' . $request->status);
    }
}